function logout(){
    $.post("includes/ajax/handlers/logout.php", function(){
        location.reload();
    });
}