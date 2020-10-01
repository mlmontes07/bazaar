<?php
namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\LoginForm;
use Laminas\Authentication\AuthenticationService;
use Laminas\Db\Adapter\Adapter;
use Laminas\Log\Logger;
use Laminas\Db\Sql\Sql;
use User\Model\User;
use Application\Library\Session;
use User\Model\Role;

class SigninController extends AbstractActionController
{
    protected $adapter;
    protected $logger;
    protected $auth;
    protected $session;
    protected $activity;

    public function __construct(Adapter $adapter, Logger $logger, AuthenticationService $auth, Session $session)
    {
        $this->adapter = $adapter;
        $this->auth = $auth;
        $this->logger = $logger;
        $this->session = $session;
        $this->sqlObj = new Sql($adapter);
    }

    public function indexAction()
    {
        if ($this->auth->hasIdentity()) {
            return $this->redirect()->toUrl('/');
        }

        $this->layout('layout/slim_layout');
        $this->logger->info('Login Action');
        $this->layout()->setVariable('page', 'authentication');

        $redirect = $this->params()->fromQuery('redirect', null);
        $request = $this->getRequest();

        $viewModel = new ViewModel();
        $form = new LoginForm();

        $recaptcha = $this->session->getConfigVariable('recaptcha');

        if ($request->isPost()) {
            $postData = $request->getPost();
            // before anything else, recaptcha
            /*
             * $gResponse = $this->session->curlWrap($config['url'], $config['method'], [
             * 'secret' => $config['secret'],
             * 'response' => $postData['g-recaptcha-response'],
             * 'remoteip' => $this->session->findIP()
             * ]);
             * $gResponse = json_decode($gResponse);
             * if (! $gResponse || ! $gResponse->success) {
             * $viewModel->setVariable('error', 'Missing or invalid response from reCaptcha. Please try again.');
             * } else {
             */
            $form->setData($postData);
            $this->logger->info('Login Action Post', [
                'post' => $postData
            ]);
            if ($form->isValid()) {
                $dataform = $form->getData();
                $this->logger->info('Form Valid', [
                    'data_form' => $dataform
                ]);
                $redirect = $dataform['redirect'];

                # check csrf validity
                $sessionCsrfToken = $this->session->getCSRFToken();
                if (!hash_equals($sessionCsrfToken, $dataform['token'])) {
                    $this->logger->info('Tried to login with a different CSRF Token', [
                        'ipAddress' => $this->session->findIP(),
                        'username' => $dataform['username'],
                        'password' => $dataform['password'],
                        'token' => $sessionCsrfToken
                    ]);
                    $viewModel->setVariable('error', 'Token mismatch. Try again.');
                } else {
                    $adapter = $this->auth->getAdapter();
                    $adapter->setIdentity($dataform['username']);
                    $adapter->setCredential($dataform['password']);

                    $result = $this->auth->authenticate();

                    if ($result->isValid()) {
                        $this->logger->info('Authenticate Valid', [
                            'result' => $result
                        ]);
                        $identityRow = $this->auth->getAdapter()->getResultRowObject();

                        if (empty($identityRow->email_token)) {
                            $this->logger->info('Authenticate valid and email verified', [
                                'result' => $result
                            ]);
                            $this->session->setUserPasswordHash($identityRow->password);
                            $this->session->setSessionItem('fullname', $identityRow->full_name);
                            $this->session->setUserLevel($identityRow->user_level);
                            $this->session->setIdentityId($identityRow->id);

                            // update last login date
                            $user_data = (new User($this->adapter))->findById($identityRow->id);
                            $this->session->setLastLogin($user_data->getLastLogin('l, F d, Y h:iA'));
                            $user_data->setLastLogin(date('Y-m-d H:i:s'))->save();

                            // fetch accessible resources by user role
                            $roleModel = new Role($this->adapter);
                            $accessList = [];
                            $roleData = null;
                            if ($user_data && $user_data->getRoleId()) {
                                $roleData = $roleModel->findById($user_data->getRoleId());
                            }

                            if ($roleData) {
                                $accessList = unserialize($roleData->getAccess());
                                $this->logger->info('Access Control List', [
                                    'ACLList' => $accessList
                                ]);
                                $this->session->setAclList($accessList);
                                $this->session->setAccess($this->processAccessList($accessList));                                
                                $this->session->setSessionItem('module_access', $this->moduleAccess($accessList));
                                unset($user_data);                                
                            }
                            return $redirect ? $this->redirect()->toUrl($redirect) : $this->redirect()->toUrl('/');
                        } else {
                            $this->logger->info('Authenticate valid but email not yet verified', [
                                'result' => $result
                            ]);
                            $this->auth->clearIdentity();
                            $viewModel->setVariable('error', 'Account not yet verified. Please confirm your email or phone number.');
                        }
                    } else {
                        $this->logger->info('Authenticate invalid', [
                            'result' => $result
                        ]);
                        $viewModel->setVariable('error', 'Authentication error. Try again.');
                    }
                }
            } else {
                $viewModel->setVariable('error', 'Missing or invalid input. Try again.');
            }
            // }
        }
        
        $csrfToken = sha1(time() . mt_srand(time()));
        $this->session->setCSRFToken($csrfToken);
        $viewModel->setVariable('csrf_token', $csrfToken);
        $viewModel->setVariable('redirect', $redirect);
        $viewModel->setVariable('ip_address', $this->session->findIP());
        $viewModel->setVariable('recaptcha_key', $recaptcha['key']);
        $viewModel->setVariable('form', $form);

        return $viewModel;
    }

    protected function processAccessList($list = [])
    {
        $return = [];
        if ($list) {
            foreach ($list as $item) {
                $item_vars = explode('_', $item);
                if (! array_key_exists($item_vars[0], $return)) {
                    $return[$item_vars[0]] = [];
                }
                if (! array_key_exists($item_vars[1], $return[$item_vars[0]])) {
                    $return[$item_vars[0]][$item_vars[1]] = [];
                }
                $return[$item_vars[0]][$item_vars[1]][] = $item_vars[2];
            }
        }
        return $return;
    }

    protected function moduleAccess($list = [])
    {
        $return = [];
        if ($list) {
            foreach ($list as $item) {
                $item_vars = explode('_', $item);
                if (! in_array($item_vars[0], $return)) {
                    $return[] = $item_vars[0];
                }
            }
        }
        return $return;
    }

    public function logoutAction()
    {
        $redirect = $this->params()->fromQuery('redirect', null);
        $this->auth->getStorage()->clear();
        return $redirect ? $this->redirect()->toUrl($redirect) : $this->redirect()->toUrl('/');
    }
}
