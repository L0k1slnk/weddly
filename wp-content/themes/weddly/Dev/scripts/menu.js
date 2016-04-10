$(function () {


    // main menu init
    var mainMenu = new Slideout({
        'panel': $('.main-wrapper')[0],
        'menu': $('.main-navigation')[0],
        'padding': 256,
        'tolerance': 70
    });

    $(document).on('click', '.js-menu-toggle', function(){
        mainMenu.toggle();
    });
    
    // main menu init
    var specialMenu = new Slideout({
        'panel': $('.main-wrapper')[0],
        'menu': $('.special-navigation')[0],
        'padding': 256,
        'tolerance': 70,
        'side': 'right'
    });

    $(document).on('click', '.js-special-toggle', function(){
        specialMenu.toggle();
    });
}); //Doc ready