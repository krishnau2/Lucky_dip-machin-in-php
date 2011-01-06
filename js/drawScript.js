
//Setup Arrays that will hold the x,y,z of each element.
var x = new Array();
var y = new Array();
var z = new Array();

var x1 = new Array();
var y1 = new Array();
var z1 = new Array();

//Get the list of items.
var items = $('li');
var items2 = $("#a");

//Animate the items.
function animate()
{

    //Step through each item.
    for(i = items.length - 1; i >= 0; i--){


        //variables for movement.
        var xVar = 40 + x[i] 			// x value
        var yVar = 50 + y[i] * z[i]++;	// y value, move towards bottom of screen
        var zVar = 20 * z[i]++;			// z value, text get larger.


        //Check to see if text position is still on the screen.
        // the #'s are %.   100 is far right or bottom, 0 is top or left.
        // for z value it's the font size in %.
        if (!xVar | xVar < 0 | xVar > 90|
            yVar < 0 | yVar > 90 |
            zVar < 0 | zVar > 1500)
            {
            //if it's off the screen randomly pick a starting place.
            x[i]= Math.random() * 2 - 1;
            y[i] = Math.random() * 2 - 1;
            z[i] = 2;

        }
        else
        {
            //if it's still on the screen apply the appropiate styles.

            $(items[i]).css("position", "absolute"); // make sure we can move the text around.
            $(items[i]).css("top", xVar+"%");  // y value
            $(items[i]).css("left", yVar+"%"); // x value

            $(items[i]).css("fontSize", zVar+"%"); // font size (illusion of perspective.)
            $(items[i]).css("opacity",(zVar)/3000); // fade in from the distance.
        }
    }

    setTimeout(animate, 5);
}
function animate2()
{

    //Step through each item.
    for(i = items2.length - 1; i >= 0; i--){


        //variables for movement.
        var xVar1 = 50 + x1[i] 			// x value
        var yVar1 = 80 + y1[i] * z1[i]++;	// y value, move towards bottom of screen
        var zVar1 = 10 * z1[i]++;			// z value, text get larger.


        //Check to see if text position is still on the screen.
        // the #'s are %.   100 is far right or bottom, 0 is top or left.
        // for z value it's the font size in %.
        if (!xVar1 | xVar1 < 0 | xVar1 > 90|
            yVar1 < 0 | yVar1 > 90 |
            zVar1 < 0 | zVar1 > 1500)
            {
            //if it's off the screen randomly pick a starting place.
            x1[i]= Math.random() * 2 - 1;
            y1[i] = Math.random() * 2 - 1;
            z1[i] = 2;

        }
        else
        {
            //if it's still on the screen apply the appropiate styles.

            $(items2[i]).css("position", "absolute"); // make sure we can move the text around.
            $(items2[i]).css("top", xVar1+"%");  // y value
            $(items2[i]).css("left", yVar1+"%"); // x value

            $(items2[i]).css("fontSize", zVar1+"%"); // font size (illusion of perspective.)
            $(items2[i]).css("opacity",(zVar1)/3000); // fade in from the distance.
        }
    }

    setTimeout(animate2, 5);
}

$(document).ready(function() {

    animate2();
    animate();
});