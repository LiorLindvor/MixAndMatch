var eBay = eBay || {};
/**
 * eBay Factory Application
 * Create objects inside the factory.
 *
 * create: make new section inside the factory.
 * run   : run a section inside the factory.
 *
 **/

eBay.factory = ( function ( $ )
{
    "use strict";

    eBay.Objects = {};eBay.storage = { };eBay.objectLoader = [];

    return {
        /**
         * @parm objectName
         * @parm ObjectContent
         * @parm type = 1 -> CAN RUN Infinity times. 0 => Can run once.
         * make new section inside the factory
         **/
        create: function( ObjectName, ObjectContent, type )
        {
            eBay.Objects[ ObjectName ] = { type: type || 0, content: ObjectContent, status: false };
        },

        //------------------------------------------------------

        /**
         * run a section inside the factory.
         **/
        run: function( ObjectName )
        {
            if( eBay.Objects[ ObjectName ] )
            {
                var objectToReturn = null;

                //--------------------------------------------
                // Is the object can run? or Already runed?
                //--------------------------------------------
                if( eBay.Objects[ ObjectName ].status == false || ( eBay.Objects[ ObjectName ].status == true && eBay.Objects[ ObjectName ].type == 1 ) )
                {
                    eBay.Objects[ ObjectName ].status = true;
                    eBay.objectLoader.push( ObjectName );
                    return eBay.Objects[ ObjectName ].content;
                }

                //-----------------------------
                // Return empty object
                //-----------------------------
                return eBay.factory._assets.getEmptyObject(eBay.Objects[ ObjectName ].content);
            }
        },

        //-------------------------------------------------------

        storage: function( key, value )
        {
            if( key == "clear" )
            {
                //-----------------------------------------
                // Change here for default storage args.
                //-----------------------------------------
                eBay.storage = { };
            }
            else
            {
                if( ! value )
                    return eBay.storage[ key ];
                else
                    eBay.storage[ key ] = value;
            }
        },

        localStorage: function( key, value )
        {

             if( ! value )
                return localStorage[ key ];
             else
                localStorage.setItem(key,value);
        },

        //-----------------------------------------------------
        _assets: {
            getEmptyObject: function( obj )
            {
                /*
                 obj = Object.keys( obj );
                 console.log(obj);
                 */

                for(var m in obj)
                {
                    if(typeof obj[m] == "function")
                        obj[ m ] = function() {};
                }
                return obj;
            },

            is_object: function()
            {
                if (Object.prototype.toString.call(mixed_var) === '[object Array]')
                    return false;
                return mixed_var !== null && typeof mixed_var === 'object';
            },

            _cookie: {
                setCookie: function (cname, cvalue, exdays)
                {
                    var d = new Date();
                    d.setTime(d.getTime() + ( exdays * 24 * 60 * 60 * 1000 ));
                    var expires = "expires=" + d.toGMTString();
                    document.cookie = cname + "=" + cvalue + "; " + expires;
                },

                getCookie: function( cname )
                {
                    var name = cname + "=";
                    var ca = document.cookie.split(';');
                    for (var i = 0; i < ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0) == ' ') c = c.substring(1);
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }
            }
        }
    }
}( jQuery ));

eBay.factory.create( "home", ( function ( $ )
{
    return {
        init: function ()
        {

            /*if( !eBay.factory.localStorage( "login" ) )
                App.openPage("login");*/
            var body = document.body,
                dropArea = document.getElementById( 'drop-area' ),
                droppableArr = [], dropAreaTimeout;

            //-----------------------
            // initialize droppables
            //-----------------------
            [].slice.call( document.querySelectorAll( '#drop-area .drop-area__item' )).forEach( function( el )
            {
                droppableArr.push( new Droppable( el,
                {
                    onDrop : function( instance, draggableEl )
                    {
                        var products = eBay.factory.storage("products");
                        eBay.factory.storage("product", (Number(eBay.factory.storage("product"))+1)); // Choose current product.
                        console.log(products[ eBay.factory.storage("product") ] [ "category" ] ); 
                        
                        //-----------------------
                        // Save user Category
                        //-----------------------
                        products[ eBay.factory.storage("product") ] [ "userCategory" ] = instance.el.getAttribute("data-name");
                        eBay.factory.storage("products",products);
                        
                        //--------------------------------------------
                        // is user choosed  the right category?
                        //---------------------------------------------
                        if( products[ eBay.factory.storage("product") ] [ "category" ] == instance.el.getAttribute("data-name") )
                        {
                            //---------------------------------------------
                            // show checkmark inside the droppabe element
                            //---------------------------------------------
                            classie.add( instance.el, 'drop-feedback' );
                            
                            //-------------------------------------
                            // Add points because user is right!
                            //--------------------------------------
                            eBay.factory.storage("points", Number(eBay.factory.storage("points"))+10);
                            var level = ( Number(eBay.factory.storage("level"))+1 );
                            eBay.factory.storage("level", level);
                            
                            $(".levelShow").html( Math.floor( Number( eBay.factory.storage("level") ) / 3 ) +1 );

                            //------------------
                            // Refresh points.
                            //------------------
                            $(".pointsShow").html( eBay.factory.storage("points") );
                            //$(".pointsShow").parent().addClass("animated teda").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function()
                            //{
                            //    $( this ).removeClass("animated teda");
                            //});

                            //------------------------------------------
                            // If user is right 3 times -> go up level
                            //------------------------------------------
                            if( Number( eBay.factory.storage("level") ) % 3 == 0 )
                            {
                                $("#user-level-up").show().addClass("animated lightSpeedIn").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function()
                                {
                                    $( this ).removeClass("animated lightSpeedIn");

                                    eBay.factory.storage("points", eBay.factory.storage("points")+30);
                                    //------------------------
                                    // Fix Refresh points bug
                                    //------------------------
                                    $(".pointsShow").html( eBay.factory.storage("points") );


                                    setTimeout( function()
                                    {
                                        $( "#user-level-up" ).addClass("animated lightSpeedOut").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function()
                                        {
                                            $( this ).removeClass("animated lightSpeedOut").hide();
                                            goNext();
                                        });
                                        
                                    },1500);

                                });
                            }
                            else
                            {
                                goNext();
                            }
                        }
                        else
                        {
                            //--------------------
                            // user is not right!
                            //--------------------
                            goNext();
                        }

                        //-----------------
                        // End of the game?
                        //-----------------
                            if( Number(eBay.factory.storage("product")) == (Number( Object.keys(products).length )-1) )
                            {
                                $("#gameover").show().addClass("animated lightSpeedIn").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function()
                                {
                                    $( this ).removeClass("animated lightSpeedIn");

                                    //--------------------
                                    // Send resulats.
                                    //--------------------

                                    $("#new-game").click( function()
                                    {
                                        setTimeout( function()
                                        {
                                            $( "#gameover" ).addClass("animated lightSpeedOut").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function()
                                            {
                                                $( this ).removeClass("animated lightSpeedOut").hide();
                                                location.reload();
                                            });
                                        },1500);
                                    });
                                    

                                });
                            }

                        //---------------------
                        // Show next product.
                        //---------------------
                        function goNext()
                        {
                            clearTimeout( instance.checkmarkTimeout );
                            instance.checkmarkTimeout = setTimeout( function() {
                                classie.remove( instance.el, 'drop-feedback' );
                                $("#ebay-product").attr("style","position: relative").addClass("bounceOutLeft animated").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function()
                                {
                                     $(this).removeClass("bounceOutLeft animated");
                                     var $this = $( this );
                                     $this.children("img").hide();
                                    
                                    $("#ebay-product img").attr("src",products[ eBay.factory.storage("product") ][ "img"] );
                                    $("#ebay-product img").show();

                                    $this.addClass("bounceInRight animated").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function()
                                    {
                                        $this.removeClass("bounceInRight animated");
                                        //---------------------------
                                        // next product shown, Done.
                                        //---------------------------
                                    });
                                });
                            }, 800 );
                        }
                    }
                } ) );
            } );
            
            //--------------------------
            // initialize draggable(s)
            //--------------------------
            [].slice.call(document.querySelectorAll( '#grid .grid__item' )).forEach( function( el )
            {
                new Draggable( el, droppableArr,
                {
                    draggabilly : { containment: document.body },
                    scroll : true,
                    scrollable : '#drop-area',
                    scrollSpeed : 20,
                    scrollSensitivity : 10,
                    onStart : function()
                    {
                        //---------------------------------
                        // add class 'drag-active' to body
                        //---------------------------------
                        classie.add( body, 'drag-active' );
                        
                        //---------------------------------------------------
                        // clear timeout: dropAreaTimeout (toggle drop area)
                        //---------------------------------------------------
                        clearTimeout( dropAreaTimeout );
                        
                        //----------------
                        // show dropArea
                        //----------------
                        classie.add( dropArea, 'show' );
                    },

                    onEnd : function( wasDropped )
                    {
                        var afterDropFn = function()
                        {
                            //----------------
                            // Hide dropArea
                            //----------------
                            classie.remove( dropArea, 'show' );

                            //--------------------------------------
                            // Remove class 'drag-active' from body
                            //--------------------------------------
                            classie.remove( body, 'drag-active' );
                        };

                        if( !wasDropped )
                            afterDropFn();
                        else
                        {
                            //----------------------------------------------------------------------------
                            // After some time hide drop area and remove class 'drag-active' from body
                            //----------------------------------------------------------------------------
                            clearTimeout( dropAreaTimeout );
                            dropAreaTimeout = setTimeout( afterDropFn, 400 );
                        }
                    }
                } );
            } );
        }
    }
}(jQuery)));

eBay.factory.create( "login", ( function ( $ )
{
    return {
        init: function ()
        {
            $("body").addClass("white");

            [].slice.call( document.querySelectorAll( 'button.progress-button' ) ).forEach( function( bttn ) {
                new ProgressButton( bttn, {
                    callback : function( instance ) {
                        var progress = 0,
                        interval = setInterval( function() {
                            progress = Math.min( progress + Math.random() * 0.1, 1 );
                            instance._setProgress( progress );

                            if( progress === 1 ) {
                                instance._stop(1);
                                clearInterval( interval );
                                App.openPage("home");
                                $("body").removeClass("white");
                            }
                        }, 650 );
                    }
                } );
            } );
        }
    }
}(jQuery)));

eBay.factory.create( "App", ( function ( $ )
{
    var Page = {
        init: function()
        {
            var thisClass = this;
            this._initHash();
            $(window).on('hashchange', function()
            {
                thisClass._initHash();
            });
        },

        _initHash: function()
        {
            var id = window.location.hash;
            id = id.replace("#!/","");

            if( id )
                Page.open(id);
        },

        open: function( id, refresh )
        {

            if( typeof  refresh === undefined) refresh = false;

            if( $( "section#" + id ).is( "*" ) )
            {
                if( eBay.factory.storage("currentPage") != id )
                {
                    var $section = $( "section#" + id );

                    //----------------------
                    // Hide all Sections
                    //----------------------
                    $("section").hide();

                    //--------------------
                    // Fade this page
                    //--------------------
                    $section.fadeIn( "fast" );

                    //------------------------------
                    // check if hash has this id
                    //------------------------------
                    if( window.location.hash != id )
                        window.location.hash = "#!/" + id;

                    history.pushState( null, null, "#!/" + id );

                    //--------------------------------
                    // Set this id as current.
                    //--------------------------------
                    eBay.factory.storage("currentPage",id);

                    //--------------------------------
                    // Open header.
                    //--------------------------------
                    $("#header").show();

                    $("#menu").animate({
                        bottom: '-370px'
                    });

                    //---------------------------------
                    // Load Page Javascript object.
                    //---------------------------------
                    eBay.factory.run( id ).init();

                    if(refresh) {
                        location.reload();
                    }
                }
            }
        }
    };

    var Api = {
        url : "http://188.166.68.101/",
        call: function( url, callback )
        {
            var request = $.ajax(
                {
                    url  : Api.url + url,
                    method : "GET",
                    crossDomain: true,
                    dataType: "json"
                });

            request.done( callback );
        }
    };

    var Facebook = {
        init: function()
        {
            window.fbAsyncInit = function()
            {
                //------------------------
                // init the FB JS SDK
                //------------------------
                FB.init({
                    appId   : APP_ID,
                    status : true, // check login status
                    cookie : true, // enable cookies to allow the server to access the session
                    xfbml  : true, // parse XFBML
                    oauth  : true // enable OAuth 2.0       
                });
            };
            
            //------------------------------------------------
            // If we've already installed the SDK, we're done
            //------------------------------------------------
            if (document.getElementById('facebook-jssdk')) {return;}
            
            //-------------------------------------------------------------------------
            // Get the first script element, which we'll use to find the parent node
            //-------------------------------------------------------------------------
            var firstScriptElement = document.getElementsByTagName('script')[0];

            //------------------------------------------------
            // Create a new script element and set its id
            //------------------------------------------------
             var facebookJS = document.createElement('script'); 
             facebookJS.id = 'facebook-jssdk';

             //--------------------------------------------------------------------
             // Set the new script's source to the source of the Facebook JS SDK
             //--------------------------------------------------------------------
             facebookJS.src = '//connect.facebook.net/en_US/all.js';

             //------------------------------------------------
             // Insert the Facebook JS SDK into the DOM
             //------------------------------------------------
             firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
        }

    };

    return {
        init: function()
        {
            var products = {};
            this.call( "products/get-min-max", function( callback )
            {

                $.each( callback["min"], function( key, val ){
                    console.log( val[ "primaryCategory" ][ "categoryName" ] );
                    products[ key ] = { 
                        "category": val[ "primaryCategory" ][ "categoryName" ],
                        "img"     : val[ "galleryURL" ],
                        "itemId"  : val[ "itemId" ],
                        "userCategory": "",
                    };
                });

                $("#header-nav").click( function()
                {
                    $("#scoreboard").slideDown();
                });

                
                /*$.each( callback["max"], function( key, val ){
                    products[ key ] = { 
                        "caetgory": val[ "primaryCategory" ][ "categoryName" ],
                        "img"     : val[ "galleryURL" ],
                        "itemId"  : val[ "itemId" ]
                    };
                });*/
                 
                 //--------------------
                // Set up first level
                //--------------------
                eBay.factory.storage("level", "0");
                eBay.factory.storage("points","0");
                eBay.factory.storage("product","0");
                
                $("#ebay-product img").attr("src",products[ "0" ][ "img" ] );

                //$("#ebay-product").css("marginTop", ( ( $( "#grid" ).height()/2 ) - 37 ) );
                
                eBay.factory.storage("products", products);
            });

            Page.init();
            
            //--------------
            // Init pages.
            //--------------

            if( !eBay.factory.storage("currentPage") )
            {
                Page.open("login");
            }
            return this;
        },

        openPage: Page.open,
        call     : Api.call,
        facebook : Facebook.init
    }
}( jQuery )));

var App = eBay.factory.run("App").init();
