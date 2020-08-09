window.onload = function(){
    $('.alert').removeClass("hide");
    $('.alert').addClass("show");
    $('.alert').addClass("showAlert");
    setTimeout(function(){
        $('.alert').removeClass("show");
        $('.alert').addClass("hide");
    }, 5000);
    $('.close-btn').click(function(){
        $('.alert').removeClass("show");
        $('.alert').addClass("hide");
        $('.hide').addClass("hidden");
    });
};