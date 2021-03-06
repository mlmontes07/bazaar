$(document).ready((function() {
    var e, s = [];
    $("#users-list-datatable").length > 0 && (e = $("#users-list-datatable").DataTable({
        columnDefs: [{
            orderable: !1,
            targets: [7]
        }]
    })),
    $(document).on("click", "#users-list-datatable tr", (function() {
        $(this).find("td").each((function() {
            s.push($(this).text().trim())
        }
        )),
        localStorage.setItem("usersId", s[0]),
        localStorage.setItem("usersUsername", s[1]),
        localStorage.setItem("usersName", s[2]),
        localStorage.setItem("usersVerified", s[4]),
        localStorage.setItem("usersRole", s[5]),
        localStorage.setItem("usersStatus", s[6])
    }
    )),
    void 0 !== localStorage.usersId && ($(".users-view-id").html(localStorage.getItem("usersId")),
    $(".users-view-username").html(localStorage.getItem("usersUsername")),
    $(".users-view-name").html(localStorage.getItem("usersName")),
    $(".users-view-verified").html(localStorage.getItem("usersVerified")),
    $(".users-view-role").html(localStorage.getItem("usersRole")),
    $(".users-view-status").html(localStorage.getItem("usersStatus")),
    "Banned" === $(".users-view-status").text() && $(".users-view-status").toggleClass("badge-light-success badge-light-danger"),
    "Close" === $(".users-view-status").text() && $(".users-view-status").toggleClass("badge-light-success badge-light-warning")),
    $("#users-list-verified").on("change", (function() {
        var s = $("#users-list-verified").val();
        e.search(s).draw()
    }
    )),
    $("#users-list-role").on("change", (function() {
        var s = $("#users-list-role").val();
        e.search(s).draw()
    }
    )),
    $("#users-list-status").on("change", (function() {
        var s = $("#users-list-status").val();
        e.search(s).draw()
    }
    )),
    $("#users-language-select2").length > 0 && $("#users-language-select2").select2({
        dropdownAutoWidth: !0,
        width: "100%"
    }),
    $("#users-music-select2").length > 0 && $("#users-music-select2").select2({
        dropdownAutoWidth: !0,
        width: "100%"
    }),
    $("#users-movies-select2").length > 0 && $("#users-movies-select2").select2({
        dropdownAutoWidth: !0,
        width: "100%"
    }),
    $(".birthdate-picker").length > 0 && $(".birthdate-picker").pickadate({
        format: "mmmm, d, yyyy"
    }),
    $(".users-edit").length > 0 && $("input,select,textarea").not("[type=submit]").jqBootstrapValidation()
}
));
