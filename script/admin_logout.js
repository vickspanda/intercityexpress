function logout() {
    var res = window.confirm("Do You Want To Log Out ???");
    if (res == true) {
        window.location.href = "../process/logout.php?user=../admin/";
    }
}