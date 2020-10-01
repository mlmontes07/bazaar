<?php
namespace User\Model;

use Laminas\Db\Adapter\Adapter;

class UserAccess
{
    const USER_ACTIONS = [
        'view',
        'add',
        'edit',
        'delete'
    ];
    const FILE_ACTIONS = [
        'view',
        'edit',
        'delete'
    ];
    const ACTION_VIEW = 1;
    const ACTION_ADD = 2;
    const ACTION_EDIT = 4;
    const ACTION_DELETE = 8;
    protected $access = [];
    protected $file_access = [];
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function addAccess($access)
    {
        $this->access[] = $access;
        return $this;
    }

    public function addFileAccess($file)
    {
        $this->file_access[] = $file;
        return $this;
    }

    public function setAccess($all_access)
    {
        $this->access = $all_access;
        return $this;
    }

    public function setFileAccess($file_access)
    {
        $this->file_access = $file_access;
        return $this;
    }

    public function checkIfAllowed($access, $is_file = false)
    {
        if ($is_file)
            if ($this->file_access)
                return in_array($access, $this->file_access);

        if ($this->access)
            return in_array($access, $this->access);

        return false;
    }

    public function contains($access, $is_file = true)
    {
        if ($is_file) {
            if ($this->file_access)
                return in_array($access, $this->file_access);
        } else {
            if ($this->access)
                return in_array($access, $this->access);
        }
        return false;
    }

    public function resetFileAccess()
    {
        $this->file_access = [];
        return $this;
    }

    public function resetAccess()
    {
        $this->access = [];
        return $this;
    }

    public function getAllAccess()
    {
        return $this->access ? $this->access : [];
    }

    public function getFileAccess()
    {
        return $this->file_access ? $this->file_access : [];
    }

    public function saveUserAccess()
    {
        return serialize($this->access);
    }

    public function saveFileAccess()
    {
        return serialize($this->file_access);
    }

    public function getAccessIds()
    {
        if (! $this->access)
            return [];
        $accessArray = [];
        $moduleResourceModel = new ModuleResource($this->adapter);
        $moduleResourceObj = null;
        foreach ($this->access as $access) {
            $exploded = explode('_', $access);
            if (! array_key_exists($exploded[0], $accessArray)) {
                $accessArray[$exploded[0]] = $exploded[0];
            }
            $moduleResourceObj = $moduleResourceModel->findById($exploded[0]);
            $accessArray[$exploded[0]] = [
                'path' => $moduleResourceObj->getPath(),
                'name' => $moduleResourceObj->getModuleName(),
                'icon' => $moduleResourceObj->getIcon()
            ];
        }
        return $accessArray;
    }

    public function __toString()
    {
        if (! $this->access)
            return '<table class="table"><thead><th>Object Name</th><th style="max-width:48px;">View</th><th style="max-width:48px;">Add</th><th style="max-width:48px;">Edit</th><th style="max-width:48px;">Delete</th></thead><tbody></tbody></table>';

        $moduleResourceModel = new ModuleResource($this->adapter);
        $moduleResourceObj = null;
        $html = '<table class="table"><thead><th>Object Name</th><th style="max-width:48px;">View</th><th style="max-width:48px;">Add</th><th style="max-width:48px;">Edit</th><th style="max-width:48px;">Delete</th></thead><tbody>';

        $accessArray = [];

        foreach ($this->access as $access) {
            $exploded = explode('_', $access);
            if (! array_key_exists($exploded[0], $accessArray)) {
                $accessArray[$exploded[0]] = [];
                if (! array_key_exists($exploded[1], $accessArray[$exploded[0]])) {
                    $accessArray[$exploded[0]][$exploded[1]] = [];
                }
            }
            $accessArray[$exploded[0]][$exploded[1]][$exploded[2]] = true;
        }

        foreach ($accessArray as $key => $array) {
            $moduleResourceObj = $moduleResourceModel->findById(intval($key));
            if ($moduleResourceObj) {
                $html .= '<tr style="background-color:#00c0ef6e;font-weight:bold;"><td colspan="5">' . $moduleResourceObj->getModuleName() . '</td>';
                $html .= '</tr>';
                $objects = $moduleResourceObj->getObjects();
                foreach ($objects as $object) {
                    $html .= '<tr><td style="padding-left:20px;">' . $object->getResource() . '</td>';
                    foreach (self::USER_ACTIONS as $action) {
                        $show = false;
                        $action_id = 0;
                        switch ($action) {
                            case 'view':
                                if ($object->getView())
                                    $show = true;
                                    $action_id = self::ACTION_VIEW;
                                break;
                            case 'add':
                                if ($object->getAdd())
                                    $show = true;
                                    $action_id = self::ACTION_ADD;
                                break;
                            case 'edit':
                                if ($object->getEdit())
                                    $show = true;
                                    $action_id = self::ACTION_EDIT;
                                break;
                            case 'delete':
                                if ($object->getDelete())
                                    $show = true;
                                    $action_id = self::ACTION_DELETE;
                                break;
                        }
                        if ($show) {
                            if (isset($array[$object->getId()]) && $array[$object->getId()]) {
                                $checked = array_key_exists($action_id, $array[$object->getId()]) ? ' checked="checked"' : '';
                            } else {
                                $checked = '';
                            }
                            $html .= '<td><label class="checkbox"><input type="checkbox"' . $checked . ' name="accessList[' . $key . '][' . $object->getId() . '][' . $action_id . ']"><i></i></label></td>';
                        } else {
                            $html .= '<td>&nbsp;</td>';
                        }
                    }
                    $html .= '</tr>';
                    // show children
                    $children = $object->getChildren();
                    if ($children) {
                        foreach ($children as $child) {
                            $html .= '<tr><td style="padding-left:40px;">' . $child->getResource() . '</td>';
                            foreach (UserAccess::USER_ACTIONS as $action) {
                                $show = false;
                                $action_id = 0;
                                switch ($action) {
                                    case 'view':
                                        if ($child->getView())
                                            $show = true;
                                            $action_id = self::ACTION_VIEW;
                                        break;
                                    case 'add':
                                        if ($child->getAdd())
                                            $show = true;
                                            $action_id = self::ACTION_ADD;
                                        break;
                                    case 'edit':
                                        if ($child->getEdit())
                                            $show = true;
                                            $action_id = self::ACTION_EDIT;
                                        break;
                                    case 'delete':
                                        if ($child->getDelete())
                                            $show = true;
                                            $action_id = self::ACTION_DELETE;
                                        break;
                                }

                                if ($show) {
                                    if (isset($array[$child->getId()]) && $array[$child->getId()]) {
                                        $checked = array_key_exists($action_id, $array[$child->getId()]) ? ' checked="checked"' : '';
                                    } else {
                                        $checked = '';
                                    }
                                    $html .= '<td><label class="checkbox"><input type="checkbox"' . $checked . ' name="accessList[' . $key . '][' . $child->getId() . '][' . $action_id . ']"><i></i></label></td>';
                                } else {
                                    $html .= '<td>&nbsp;</td>';
                                }
                            }
                            $html .= '</tr>';
                        }
                    }
                }
            }
        }
        $html .= '</tbody></table>';
        return $html;
    }
}