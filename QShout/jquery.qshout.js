/*  
 * Project: QShout - Shoutbox Widget for jQuery
 * Version: v1.1.8 (28/09/‎2010, ‏‎10:53 AM)
 * URL    : http://qshout.borisding.com
 * License: MIT  (http://www.opensource.org/licenses/mit-license.php)
 *          Copyright (c) 2010, Boris Ding P H
 */

(function($){
      //public QShout
      $.QShout = function( uSettings ){                   
      //default settings    
       settings = {
        //misc.
        qsId        : "qsId",
        serverPage  : "class_qshout.php",
        loader      : "Loading...",
        timer       : 60000,
        maxRow      : 30,
        //shoutbox's body
        bwidth      : "220px",
        bheight     : "300px",
        bBorderWidth: "1px",
        bBorderStyle: "solid",
        bBorderColor: "#000000",
        bFontSize   : "11px",
        bFontFamily : "Verdana, Calibri, Arial",
        blinkColor  : "#ffccff",
        //shoutbox's content
        evenRowColor: "#f5f5f5",
        oddRowColor : "#ffffff",
        rowPadding  : "4px",
        ipCursor    : "help",
        dUrlColor   : "#888888",
        //shoutbox's footer
        fFieldHight : "auto",
        fFieldSize  : 20,
        fFontSize   : "11px",
        fBorderWidth: "1px",
        fBorderStyle: "solid",
        fBorderColor: "#000000",
        fBgColor    : "#f7f7f7"
       };
      //merge/overwrite with user's settings
       settings = ( uSettings )? $.extend( settings, uSettings )
                               : settings;

      if( settings.qsId ){
      //init shoutbox
        $.QShout.init();
      //bind 'Enter' key, code 13 to submit
        $('#qName, #qUrl, #qMessage').keypress(function(e){
          code = e.keyCode ? e.keyCode : e.which;
          if( code.toString() == 13 ){
            $.QShout.validatePost();
          }
        });
      }     
   };

   $.QShout = $.extend( $.QShout, {
      //load html content
      init: function(){
      //qShout's html      
      var qShoutHtml = "<table cellpadding='0' id='qWrapper'>" +
                       "<tr><td>"                +
                       //shoutbox's content
                       "<div id='qShout'></div>" +
                       "</td></tr>"              +
                       //shoutbox's footer
                       "<tr><td>"                +
                       "<div id='qFooter'>"      +
                       "<table>" +
                       "<tr><td>"                +
                       "<label>Name: </label>"   +
                       "</td><td>"               +
                       "<input type='text' id='qName' maxlength='30'>" +
                       "</td></tr>"              +

                       "<tr><td>"                +
                       "<label>URL: </label>"    +
                       "</td><td>"               +
                       "<input type='text' id='qUrl'>" +
                       "</td></tr>"              +

                       "<tr><td>"                +
                       "<label>Message: </label>"+
                       "</td><td>"               +
                       "<input type='text' id='qMessage' maxlength='250'>" +
                       "</td></tr>"              +

                       "<tr><td></td>"           +
                       "<td><input type='button' value='Post' onClick='$.QShout.validatePost();' id='qPostBtn'> "+
                       "<a href='javascript:void(0);' onClick='$.QShout.init();'>Refresh</a>"+
                       "</td></tr>" +
                       "</table>"   +
                       "</div>"     +
                       "</div>"     +
                       "</td></tr>" +
                       "</table>";

      $("#" + settings.qsId ).html( qShoutHtml )                       
                             .each(function(){
     
             $(this).find("#qFooter table").css({
               'border-style'    : settings.fBorderStyle,
               'border-width'    : settings.fBorderWidth,
               'border-color'    : settings.fBorderColor,
               'width'           : '100%',
               'background-color': settings.fBgColor,
               'font-size'       : settings.fFontSize
              });

          $(this).find("#qShout").html( settings.loader )
                                 .each(function(){
               $(this).css({
               'border-style': settings.bBorderStyle,
               'border-width': settings.bBorderWidth,
               'border-color': settings.bBorderColor,
               'height'      : settings.bheight,
               'width'       : settings.bwidth,
               'overflow'    : 'auto'
               });
          });
       });

       //style footer's form
       this.styleFooterEle();

       //get content of shout box
        setTimeout( function(){
         $.QShout.loadContent();
        }, 300 );
      },
     
      styleFooterEle: function(){
       var inputs = $("#qFooter :input");

      //iterate to check each element type
        inputs.each(function() {
          var currentEleType = this.type;
          switch(currentEleType){
           case "text":
            $(this).css({
             'border-width' : settings.fBorderWidth,
             'border-style' : settings.fBorderStyle,
             'border-color' : settings.fBorderColor,
             'font-size'    : settings.fFontSize,
             'height'       : settings.fFieldHeight
            });
            //set the size of textfield
            this.size = settings.fFieldSize;
            break;
            case "button":
             $(this).css({
              'font-size': settings.fFontSize,
              'height'   : settings.fFieldHeight
             });
              break;
          }//end switch
        });
      },

      loadContent: function( action ){
       
       var act = {load: "load"};
       if( action ) { act = $.extend( act, action ) };

       var maxRow = ( settings.maxRow < 0 ) ? 30 
	                                    : settings.maxRow;
											
       var param = "maxRow="+ maxRow +"&action=get";
       var url   = settings.serverPage + "?" + param;
       $.getJSON(url,
        function( data ){
         var arrayMessage = data.chat.message;         
         var content = "<ul style='margin:0; padding:0px; list-style: none;'>";
          $.each( arrayMessage, function(i){
            if( arrayMessage[i].url != "" ){
             arrayMessage[i].user = "<a href='"+ arrayMessage[i].url +"'>"+ arrayMessage[i].user + "</a>";
            }
           var message = arrayMessage[i].text;
               message = message.replace(/%22/gi,'"');
           content += "<li>"+
                      "<span>"+
                      arrayMessage[i].user +
                      "</span>"+
                      ": "+
                      message+
                      "<div id='dateUrl'>" +
                      arrayMessage[i].time +
                      " "+
                      "<a title='IP: "+ arrayMessage[i].ip +"' id='qIp'>&equiv;</a>"+
                      "</div>"+
                      "</li>";
          });
           content += "</ul>";
           
           //manipulate content's css
              $("#qShout").html(content)
                          .each(function(){
                $(this).scrollTop( settings.bheight );

                $(this).find("ul").css({                                           
                  'font-size'  : settings.bFontSize,
                  'font-family': settings.bFontFamily
                });

                $(this).find("ul>li:even").css({
                  'background-color' : settings.evenRowColor,
                  'padding'          : settings.rowPadding
                });

                $(this).find("ul>li:odd").css({
                  'background-color' : settings.oddRowColor,
                  'padding'          : settings.rowPadding
                });

                $(this).find("ul>li a#qIp").css( 'cursor', settings.ipCursor );

                $(this).find("ul>li div").css({
                  'text-align': 'right',
                  'color': settings.dUrlColor
                });

                $(this).find("ul>li span").css({
                  'color': '#333',
                  'font-weight': 'bold'
                });

                $(this).find("ul>li span a").css({
                  'color': '#333',
                  'font-weight': 'bold'});

              //apply animation for newly added
               if( act.load === "inserted" ){
                 var oriColor = $(this).find("ul>li:first").css('background-color');
                 $(this).find("ul>li:first").css('background-color', settings.blinkColor);
                    $(this).find("ul>li:first").animate({
                      opacity: 0.4
                      },'slow',function(){
                       $(this).css({
                         'background-color': oriColor,
                         'opacity': 1
                     });
                    });
                   }
              });

          //reload the content after interval time
          setTimeout( function(){
			settings.timer = ( settings.timer < 0 )? 60000
			                                       : settings.timer;
              $.QShout.loadContent();
          }, settings.timer );
        });
      },
      //inputs validation
      validatePost: function(){
       var name    = $.trim($("#qName").val());
       var url     = $.trim($("#qUrl").val());
       var message = $.trim($("#qMessage").val());

       if( name == "" || name == null ){
         alert("Name is emtpy!");
         $("#qName").focus();
         return false;
       }
       
       if( name.length > 30 ){
         alert("Name is too long (Max. 30 char)!");
         $("#qName").focus();
         return false;
       }
       
       if( message == "" || message == null ){
         alert("Message is emtpy!");
         $("#qMessage").focus();
         return false;
       }
       if( url != "" ){
         var checkURL = new RegExp();
         checkURL.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
         if( !checkURL.test(url) ){
           alert("Invalid URL!");
           $("#qUrl").focus();
           return false;
         }
       }
       this.postShout();
      },
     //post inputs
     postShout: function(){
       var user    = this.encURI( $("#qName").val() );
       var url     = this.encURI( $("#qUrl").val() );
       var message = this.encURI( $("#qMessage").val() );
       
       //disable post button
       $("#qPostBtn").attr("disabled", true);

      var inputs = "user=" + user + "&url=" + url + "&message=" + message + "&action=send";
      $.post(settings.serverPage, inputs, function( result ){
        result = $.trim(result);        
        if( result === "done" ){
            clearInterval( settings.timer );
	    //load inserted
            $.QShout.loadContent({
              load: "inserted"
            });
            //clear all textfield value
            $("#qFooter :input").each(function(){
             if( this.type === "text" ){
               this.value = "";
             }else if( this.type === "button" || this.type === "submit" ){
               $(this).attr("disabled", false);
             }
          });
        }
      });
     },
    //encode
    encURI: function( string ){
      return encodeURIComponent(string);
     }
    });

})(jQuery);


