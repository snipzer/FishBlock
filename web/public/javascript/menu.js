
var magicButton = document.getElementById("magicButton");
var menuBlock = document.getElementById("menuBlock");

if(menuBlock && magicButton) {
    magicButton.addEventListener("click", function(){
        if(!$( menuBlock ).hasClass( "menuBlockExpanded" )) {
            // Petit instant JQuery...
            $( menuBlock ).addClass( "menuBlockExpanded" );
        } else {
            $( menuBlock ).removeClass( "menuBlockExpanded" );
        }

    }, false);

    document.addEventListener("click", function(e) {
        console.log($(e.srcElement).parents(".menuButtons"));
        if($(e.srcElement).parents(".menuButtons").length == 0 && e.srcElement !== magicButton) {
            $( menuBlock ).removeClass( "menuBlockExpanded" );
        }
    }, false);
}