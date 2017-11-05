<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107262286-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-107262286-1');
</script>

    <meta charset="utf-8" />
    <title>Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link type="image/x-icon" rel="shortcut icon" href="http://www.k1-hagen.de/templates/k1/favicon.ico">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" media="print" href="./css/druck.css">
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

    <script type="text/javascript" src="js/jquery-sortable-min.js"></script>
    <script type="text/javascript" src="js/table-sort.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        var Base64 = {
            _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
            encode: function(e) {
                var t = "";
                var n, r, i, s, o, u, a;
                var f = 0;
                e = Base64._utf8_encode(e);
                while (f < e.length) {
                    n = e.charCodeAt(f++);
                    r = e.charCodeAt(f++);
                    i = e.charCodeAt(f++);
                    s = n >> 2;
                    o = (n & 3) << 4 | r >> 4;
                    u = (r & 15) << 2 | i >> 6;
                    a = i & 63;
                    if (isNaN(r)) {
                        u = a = 64
                    } else if (isNaN(i)) {
                        a = 64
                    }
                    t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a)
                }
                return t
            },
            decode: function(e) {
                var t = "";
                var n, r, i;
                var s, o, u, a;
                var f = 0;
                e = e.replace(/[^A-Za-z0-9+/=]/g, "");
                while (f < e.length) {
                    s = this._keyStr.indexOf(e.charAt(f++));
                    o = this._keyStr.indexOf(e.charAt(f++));
                    u = this._keyStr.indexOf(e.charAt(f++));
                    a = this._keyStr.indexOf(e.charAt(f++));
                    n = s << 2 | o >> 4;
                    r = (o & 15) << 4 | u >> 2;
                    i = (u & 3) << 6 | a;
                    t = t + String.fromCharCode(n);
                    if (u != 64) {
                        t = t + String.fromCharCode(r)
                    }
                    if (a != 64) {
                        t = t + String.fromCharCode(i)
                    }
                }
                t = Base64._utf8_decode(t);
                return t
            },
            _utf8_encode: function(e) {
                e = e.replace(/rn/g, "n");
                var t = "";
                for (var n = 0; n < e.length; n++) {
                    var r = e.charCodeAt(n);
                    if (r < 128) {
                        t += String.fromCharCode(r)
                    } else if (r > 127 && r < 2048) {
                        t += String.fromCharCode(r >> 6 | 192);
                        t += String.fromCharCode(r & 63 | 128)
                    } else {
                        t += String.fromCharCode(r >> 12 | 224);
                        t += String.fromCharCode(r >> 6 & 63 | 128);
                        t += String.fromCharCode(r & 63 | 128)
                    }
                }
                return t
            },
            _utf8_decode: function(e) {
                var t = "";
                var n = 0;
                var r = c1 = c2 = 0;
                while (n < e.length) {
                    r = e.charCodeAt(n);
                    if (r < 128) {
                        t += String.fromCharCode(r);
                        n++
                    } else if (r > 191 && r < 224) {
                        c2 = e.charCodeAt(n + 1);
                        t += String.fromCharCode((r & 31) << 6 | c2 & 63);
                        n += 2
                    } else {
                        c2 = e.charCodeAt(n + 1);
                        c3 = e.charCodeAt(n + 2);
                        t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
                        n += 3
                    }
                }
                return t
            }
        }

		


        myStartFrage = 0;

        myCounter = 0;
        myOK = 0;
        myNOK = 0;
        isEditable = true;
        code = false;
        superuser = false;

        isSurvey = true;

        myElementSwitch = "choice";



        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
		
		   session = "<?php echo session_id(); ?>";
            if (getUrlParameter("session")) {
                session = getUrlParameter("session");
            }
			token = null; 
			if (getUrlParameter("token")) {
                token = getUrlParameter("token");
            }

        function logAnswer(result, type, title, question, answer) {
            myLog =  '"' + result + '"' + ';' + '"' + type + '"' + ';' + '"' + title + '"' + ';' + '"' + question + '"' + ';' + '"' + answer + '"';
            
			myLog = {"result":result,"type":type,"title":title,"question":question,"answer":answer}
			console.log(myLog);

            $.post("./insertAnswer.php", {
                "code": code,
                "text": JSON.stringify (myLog),
                "session": session,
				"token": token
            });
        }

        myVar = {
            "id": 2,
            "fragen": [{
                "theme": "Thema",
				"session": session,
                "qid": 1,
                "head": "Frage",
				"additionalHTML": "", 
                "elements": "choice", //choice, text, both
                "choicetype": "question", //survey, question
                "choice": {
                    "a": "Answer A",
                    "b": "Answer B",
                    "c": "Answer C",
                    "d": "Answer D"
                },
                "solution": "a",
                "hint": "Hint"
            }]
        };


        mydisabled = false;

        $(function() {
            $('#emailLink').on('click', function(event) {
                event.preventDefault();
                // alert("Huh");
                var email = 'test@theearth.com';
                var subject = 'Circle Around';
                var emailBody = 'http://www.google.de%0D%0D';
                window.location = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
            });
        });


        // var myQuestion; 
        // var myQuestionCounter=0;

        newQuestion = function() {

            //saveQuestion();
            $('#onlinearea [value]').prop('checked', false);
            // alert("new");
            //myQuestionCounter = myQuestionCounter + 1;
            myStartFrage = myStartFrage + 1;
			saveQuestion(function(){
			
			
           // 
            showCounts();

            $('#headwrite').val("");
            $('[myvalue]').val('');
            $('#ok,#alert').html("...");
            $('.CE').prop("contentEditable", true);
			
			
			});
			
        }

        function getQuestionType() {
            var myreturn = "question";

            if ($(':checked:first').length == 0 && isSurvey) {
                myreturn = "survey";
            }
            return myreturn;
        }


        saveQuestion = function(callback,input) {
            //alert(myQuestion);
			$('.nav-tabs').css('background-color','lightgrey');
			$('.glyphicon-floppy-disk').addClass('glyphicon-floppy-open');
            title = $('#headline').text();
            document.title = title;
            if (!myVar) {

                myVar = {

                    "fragen": [{
                        "theme": title,
						"session": session,
                        "qid": "",
                        "head": "",
						"additionalHTML": "", 
                        "elements": "both", //choice, text, both
                        "choicetype": "survey", //survey, question
                        "choice": {
                            "a": "",
                            "b": "",
                            "c": "",
                            "d": ""
                        },
                        "solution": "",
                        "hint": "Denke doch an..."
                    }]
                };
            }

			myObject = {
                "theme": title,
				"session": session,
                "qid": myStartFrage,
                "head": $('#headwrite').val(),
				"additionalHTML": $('#additionalHTML').html(), 
                "elements": myElementSwitch,
                "choicetype": getQuestionType(),
                "choice": {
                    "a": $('[myvalue="a"]').val(),
                    "b": $('[myvalue="b"]').val(),
                    "c": $('[myvalue="c"]').val(),
                    "d": $('[myvalue="d"]').val()
                },
                "solution": $(':checked:first').prop("value"),
                "hint": $('#alert').html(),
                "ok": $('#ok').html()
            }
			
		//	alert($(':checked:first').val());
			
			 $.getJSON("./getText.php?code=" + code + '&ts=' + Date.now(), function(json) {
         
                    myCheckVar =  convertMultilineJSON(json);
					//alert($('#headwrite').val());
					//alert(myCheckVar.fragen.length);

				if ( myCheckVar.fragen.length > myVar.fragen.length) {
				alert('Es ist ein Unterschied aufgefallen - es arbeitet anscheinend eine weitere Person an den Fragen. Die Frage '+ (myStartFrage +1) + ' wird von Ihnen überschrieben.' );
				
				
				
				
				}
				myVar = myCheckVar;
				myVar.fragen[myStartFrage] = myObject;
			

           if (input) {
                //alert(input);
                $.post("./update.php", {
                    "code": code,
                    "text": JSON.stringify(input),
                    "title": title
                });
                myVar = $.extend(true, {}, input);

            } else { 
                $.post("./update.php", {
                    "code": code,
                    "text": JSON.stringify(myVar),
                    "title": title
                });
            }


                    // createEncodedLink();
                   /* isEditable = false;
                    $('.CE').prop("contentEditable", false);
                    $('#alert,#ok').hide();
                    getLSCounter(myVar.id);
                    mysetCounter(myCounter, myOK, myNOK);
                    myinit();
                    myinitbuttons(); */
                   

//				   myinitbody(myStartFrage);

				if(callback) { 
				//alert (callback);
				callback();
				$('.nav-tabs').css('background-color','white');
				$('.glyphicon-floppy-disk').removeClass('glyphicon-floppy-open');
				}


                });

          

        }

        createEncodedLink = function() {
            saveQuestion(function(){null;});
            //console.log(myQuestion);



            //alert(myVar);
            myCode = $.trim(window.location.href.replace('#offlinearea', '').replace('setsuperuser', '_'));
            $('#linkText').html("<a target=\"_blank\" href=\"" + myCode + "\">  <img class=\"qr-code\" src=\"http://qrickit.com/api/qr?d=" + encodeURIComponent ( myCode) + "\" /></a> ");
            $('#linkText').append("<p>" + myCode + "</p>");
        }

        setLSCounter = function(counter, ok, nok) {
            localStorage.setItem(myVar.id, JSON.stringify({
                "counter_ok": ok,
                "counter_nok": nok,
                "counter": counter
            }));
            var myObj = localStorage.getItem(myVar.id);

        }

        getLSCounter = function(id) {
            if (localStorage.getItem(id)) {
                var myObj = localStorage.getItem(id);
                myObj = JSON.parse(myObj);
                myCounter = parseInt(myObj.counter);
                myOK = parseInt(myObj.counter_ok);
                myNOK = parseInt(myObj.counter_nok);
            }


        }



        mysetCounter = function(counter, ok, nok) {
            myCounter = counter;
            myOK = ok;
            myNOK = nok;
            $('#counter').html(myCounter);
            $('#counter_ok').html(myOK);
            $('#counter_nok').html(myNOK);
            setLSCounter(counter, ok, nok);
        }

        myRestartCounter = function(input) {
            mysetCounter(input, input, input);
        }


        myinit = function() {




            $('#body').find('.list-group-item').removeClass('alert');
            $('#body').find('.list-group-item').removeClass('alert-danger');
            $('#body').find('.list-group-item').removeClass('alert-success');

            $('#body').find('[type="checkbox"]').attr('disabled', false);
            mydisabled = false;
            if (!isEditable) {
                $('#alert').hide();
                $("#ok").hide();
            }
            $("#again").hide();

            $("#next").hide();
            $('#button').prop('disabled', true);




        };




        myinitbuttons = function() {

            $('#elementswitch button').click(function() {

                if ($(this).attr('mytype') == 'both') {
                    myElementSwitch = "both";
                    $('#body .myHidden').removeClass('myHidden');
                }

                if ($(this).attr('mytype') == 'text') {
                    myElementSwitch = "text";
                    $('.myTextarea').removeClass('myHidden');
                    $('.myChoice').addClass('myHidden');
                }

                if ($(this).attr('mytype') == 'choice') {
                    myElementSwitch = "choice";
                    $('.myTextarea').addClass('myHidden');
                    $('.myChoice').removeClass('myHidden');
                }


            });

            $('#clicklink').click(function() {
                // alert('dd');
                createEncodedLink();

            });
$('#clickhome').click(function() {
	 $('#clicksave').parent().show();
	 myinitbody(myStartFrage);
	
});

            $('#clicksorting').click(function() {
                  $('#clicksave').parent().hide();
                var rows = "";
                $.each(myVar.fragen, function(s, w) {

                    if (myVar.fragen[s].head) {

                        myAnswers = "";
                        $.each(myVar.fragen[s].choice, function(k, v) {
                            if (k == myVar.fragen[s].solution) {
                                myAnswers += '<p class="solution" mynr="' + k + '"> <span  class="glyphicon glyphicon-ok  "  ></span>' + v + '</p>';
                            } else {
                                myAnswers += '<p class="nosolution" mynr="' + k + '"> <span  class="placeholder"  ></span>' + v + '</p>';
                            }
                        });

                        rows += '<tr class="" oldnr="' + s + '">\
                    <td><span class="question">' + myVar.fragen[s].head + '</span></td>\
                    <td>' + myAnswers + '</td>\
					 <td><span  class="glyphicon glyphicon-trash  "  ></span></td>\
					</tr>';
                    }

                });


                $('#sortingbody').html('<table class="table table-striped table-bordered sorted_table">\
                <thead>\
                  <tr>\
                    <th>Frage</th>\
                    <th>Antwort <span  class="glyphicon glyphicon-eye-open  "  style="cursor:pointer" ></span></th>\
					<th>Optionen</th>\
                  </tr>\
                </thead>\
                <tbody style="cursor:pointer;" >' +
                    rows +
                    '</tbody>\
              </table>');
                // $('#sortingbody').html('ss');
                inittable($('#sortingbody'));
				myinitbody(myStartFrage);

            });


            $('#clickedit').click(function() {
                // alert('dd');
                if ($(this).find('.glyphicon').attr('mystatus') == 'inactive') {
                    $(this).find('.glyphicon').attr('mystatus', 'active');
                    $(this).find('.glyphicon').css('color', 'red');

                    $('.myEditable').show();
                    $('.myReadable').hide();
					$('.CE').prop("contentEditable", true);
                    isEditable = true;
                    $('#alert,#ok').show();
                    $('#elementswitch').removeClass('myHidden');
                    $('#headline').prop('contenteditable', true);

                    $('#onlinearea [value="' + myVar.fragen[myStartFrage].solution + '"]').prop('checked', true);


                    if (parseInt(myStartFrage + 1) >= myVar.fragen.length) {
                        $("#link_next").removeClass("disabled");
                        $("#link_next span").text('*Neu');
                    }

                } else {
                    $('.myEditable').hide();
                    $('.myReadable').show();
                    $('#headline').prop('contenteditable', false);
                    if (parseInt(myStartFrage + 1) >= myVar.fragen.length) {
                        $("#link_next span").html('&rarr;')
                    }

$(this).find('.glyphicon').attr('mystatus', 'inactive');
                    $(this).find('.glyphicon').css('color', 'lightgrey');
                    isEditable = false;
                    $('#alert,#ok').hide();
$('.CE').prop("contentEditable", false);

                    
                    $('#elementswitch').addClass('myHidden');
                    saveQuestion(function() {
					
					
                    myinitbody(myStartFrage);
					$('#onlinearea [value]').prop('checked', false);
					
					});
                    
                }


            });

            function downloadFile(name, input) {

                var downloadLink = document.createElement("a");
                var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(input);
                downloadLink.href = uri;
                downloadLink.download = name;
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            }

            $('#offlineversion').click(function() {
                /* if($(this).attr('myvar') == "print" ) {
                 $(this).html('zurück');
                 $('#onlinearea').hide();
                 $('#offlinearea').show();
                 $(this).attr('myvar','back');
                 }
                 else {
                  $(this).attr('myvar','print');
                  $(this).html('Druckversion');
                   $('#onlinearea').show();
                  $('#offlinearea').hide();
                 } */
                //$('#offlinearea').show();

                var myText = "<hr/>";

                //console.log(myVar);

                $('#offlinetext').html('');
                myLastTheme = "";
                $.each(myVar.fragen, function(s, w) {
                    //myText += myVar.fragen[s].head;
                    //console.log(w);
                    myText = "";
                    if (myLastTheme != w.theme) {
                        myText += '<h3>' + w.theme + '</h3>';
                    }
                    myLastTheme = w.theme;
                    myText += '<div class="panel panel-default" style="page-break-inside: avoid;">';

                    myText += '<div class="panel-heading" ><h4>' + w.head + '</h4></div>';
                    myText += '<table width="100%"><tbody>';
                    $.each(w.choice, function(k, v) {

                        s1 = "";
                        s2 = "";
                        if (v && v.length - 1 >= 0) {
                            //alert(v);
                            // console.log(v);
                            //console.log(w.solution);
                            if (isEditable) {

                                if (k == w.solution) {
                                    s1 = "X";
                                    //s2 = "</b>";
                                } else {
                                    s1 = "";
                                    // s2 = "";
                                }

                            }

                            /*  myText +='<li class="list-group-item">\
                                                     <div class="checkbox">\
                                                         <label>\
                                                             <input type="checkbox" value="'+k +'" disabled="true"> <span myvalue="'+k +'" class="CE"> '+ s1 + v + s2 +'</span>\
                                                         </label>\
                                                     </div>\
                                                 </li>'; */

                            //myText += v;
                            myText += '<tr  style="padding:20px;  border-bottom: 1px solid #ddd;"><td style="border: 1px solid #ddd; width:34px; min-height:20px; padding:8px; text-align:center; ">' + s1 + '</td><td  style="  min-width:15px; min-height:20px; padding:8px;">' + v + '</td></tr>';
                        }


                    });

                    myText += '</tbody></table>';
                    myText += '</div>';
                    $('#offlinetext').append(myText);

                });

                //console.log(myText);



            });


            $('#clickresults').click(function() {
              
                    
				  $('#offlinetext').html('Daten werden geladen...');
		
					$.get('./getResults.php?code='+code,function(data) {
							
							$('#offlinetext').html('<a id="myDownloadExcel">Excel-Verbindungsdatei</a> | ');
							//$('#offlinetext').append('<a id="myDownload">CSV-Datei (UTF-8)</a>');
							$('#offlinetext').append(data.replace('<table>','<table id="myResults">'));
						
						     $('#myResults td').css('border','1px solid black');
							 $('#myResults td').css('text-align','center');
							 $('#myResults td').css('padding','2 px');
							 $('#myResults').css('width','100%');
							 $('#myResults thead').css('background-color','grey');
							 $('#myResults tr:odd').css('background-color','lightgrey');
							 $('#myResults tr').each(function() {$(this).find('td:eq(2)').css('font-size','small'); }); 
						
						$('#myDownload').click(function() {
                        downloadFile('antworten_' + code + '.csv', myText1);
                    });
					//alert('drin');
					myIQY = 'WEB\r\n\
1\r\n\
'+$.trim(window.location.href.replace(/\/dv.*/gim, '/dv/getResults.php?code='+code))+'\r\n\
\r\n\
Selection=EntirePage\r\n\
Formatting=None\r\n\
PreFormattedTextToColumns=True\r\n\
ConsecutiveDelimitersAsOne=True\r\n\
SingleBlockTextImport=False\r\n\
DisableDateRecognition=False\r\n\
DisableRedirections=False\r\n';

										$('#myDownloadExcel').click(function() {
											downloadFile('getResults_' + code + '.iqy', myIQY);
										});
						
						});		
					


                   
				   
					

                    //downloadFile('antworten_'+code+'.csv', '"STATUS";"TYPE";"THEME";"QUESTION";"ANSWER"\r\n' + data.replace(/\|/gim,'\r\n'));





            });
			$('#clicksave').click(function() {
				saveQuestion(function(){null;});
			});


            $('.badge').dblclick(function() {

                myinit();
                myRestartCounter(0);
                myStartFrage = 0;
                myinitbody(myStartFrage);
            });

			
			function myPrev(myThis) {
				//	alert('yaeh');
                myinit();
                $('#link_next').removeClass("disabled");
                if (myVar.fragen[myStartFrage - 1]) {
                    myStartFrage = myStartFrage - 1;
                    myinitbody(myStartFrage);
                    if (isEditable) {
                        $('#onlinearea [value="' + myVar.fragen[myStartFrage].solution + '"]').prop('checked', true);
                    } else {
                        $('#onlinearea [value]').prop('checked', false);
                    }
                } else {
                    //	alert("Sie haben alle Fragen beantwortet");
                    myStartFrage = 0;
                    myinitbody(myStartFrage);
                }

                if (parseInt(myStartFrage + 1) == 1) {
                    $(this).addClass("disabled");
                }
				
				
			}
			
			
            $('#link_previous').click(function(e) {
                e.preventDefault();
                $("#link_next span").html('&rarr;')
                if (isEditable) {
					
                    saveQuestion(function () {myPrev($(this)); });

                } else {
					myPrev($(this));
					
				}

                

            });


			function myNext(myThis) {
				
				
				


                    if (myVar.fragen[myStartFrage + 1]) {
                        $('#link_previous').removeClass("disabled");
                        myStartFrage = myStartFrage + 1;
                        myinitbody(myStartFrage);

                        if (isEditable) {
                            $('#onlinearea [value="' + myVar.fragen[myStartFrage].solution + '"]').prop('checked', true);
                        } else {
                            $('#onlinearea [value]').prop('checked', false);
                        }

                    } else if (!myThis.hasClass("disabled")) {
                        //	alert("Sie haben alle Fragen beantwortet");
						$('#link_previous').removeClass("disabled");
                        newQuestion();
						}
					
                    $("#link_next span").html('&rarr;')
                    if (parseInt(myStartFrage + 1) >= myVar.fragen.length) {
                        //	alert(parseInt(myStartFrage + 1));
                        if (!isEditable) {

                            $(this).addClass("disabled");

                        } else {
                            $(this).removeClass("disabled")
                            $("#link_next").removeClass("disabled");
                            $("#link_next span").text('*Neu');

                        }


                    }
			} 
			
			

            $("#link_next").click(function(e) {

                    e.preventDefault();
                    if (isEditable) {
					

                        saveQuestion( function(){  myNext($(this)); });


                    } else {
                    myNext($(this));
					}
                    

                }

            );


            $("#button_next").click(function(e) {
                    e.preventDefault();
                    //	alert('yaeh');
                    myinit();
                    $('#link_previous').removeClass("disabled");
                    if (myVar.fragen[myStartFrage + 1]) {

                        myStartFrage = myStartFrage + 1;
                        myinitbody(myStartFrage);
                    } else {
                        //alert("Sie haben alle Fragen beantwortet");

                        $('#mymodal').modal('show');
                        $('#mymodal').find('.modal-title').html('Sie haben alle Fragen beantwortet');
                        $('#mymodal').find('.modal-body').html('Versuche: <span class="badge" title="Versuche"><span  class=" glyphicon glyphicon-asterisk"  ></span> <span >' + myCounter + '</span></span><br/>Korrekte Antworten: <span class="badge" title="Treffer"><span class=" glyphicon glyphicon-ok"  ></span><span >' + myOK + '</span></span><br/>Falsche Antworten: <span class="badge" title="Patzer"><span class=" glyphicon glyphicon-remove" ></span><span >' + myNOK + '</span></span>');


                        //<span class="badge" title="Treffer"><span class=" glyphicon glyphicon-ok"  ></span><span id="counter_ok">0</span></span>
                        //<span class="badge" title="Patzer"><span class=" glyphicon glyphicon-remove" ></span><span id="counter_nok">0</span></span>
                        //	myStartFrage = 0;
                        //	myinitbody(myStartFrage);
                    }

                }

            );




            $("#button_renew").click(function() {


                    myinit();

                }

            );

            $("#button").click(function() {

                /*  if ($('#body').find('[type="checkbox"]:checked').size() == 0 ) {
                      alert("Sie müssen sich schon für eine Antwort entscheiden.");


                      return false;
                  } */


                mysetCounter(myCounter + 1, myOK, myNOK);
                myinit();
                mydisabled = true;
                $('#body').find('[type="checkbox"]').attr('disabled', 'true');
                thisTextarea = $('#body').find('textarea').val();
                if (myVar.fragen[myStartFrage].elements == "text" || myVar.fragen[myStartFrage].elements == "both") {
                    $('#button_renew').prop('disabled', false);

                    $('#next').fadeIn(300);
                    logAnswer('OK', myVar.fragen[myStartFrage].choicetype, myVar.fragen[myStartFrage].theme, myVar.fragen[myStartFrage].head, $('#body').find('textarea').val());
                }
                $('#body').find('[type="checkbox"]:checked').each(function() {

                    // console.log($(this).val());

                    if (myVar.fragen[myStartFrage].solution == $(this).val() || myVar.fragen[myStartFrage].choicetype == "survey") {
                        myattr =
                            $(this).parents('.list-group-item').first().addClass('alert alert-success');
                        $('#ok').show(300);

                        $('#next').fadeIn(300);
                        mysetCounter(myCounter, myOK + 1, myNOK);

                        logAnswer('OK', myVar.fragen[myStartFrage].choicetype, myVar.fragen[myStartFrage].theme, myVar.fragen[myStartFrage].head, $.trim($(this).siblings('span').text()));
						if (myVar.fragen[myStartFrage].choicetype == "survey")  {$('#button_next').click();}   
						$('#button_renew').prop('disabled', true);						

				   } else {
                        $(this).parents('.list-group-item').first().addClass('alert alert-danger');
                        $('#button_renew').prop('disabled', false);

                        $('#alert').show(200);
                        $('#again').fadeIn(200);
                        mysetCounter(myCounter, myOK, myNOK + 1);

                        logAnswer('NOK', myVar.fragen[myStartFrage].choicetype, myVar.fragen[myStartFrage].theme, myVar.fragen[myStartFrage].head, $.trim($(this).siblings('span').text()));

                    }

                });

            });
        };

        //ENDE myinitButtons

        showCounts = function() {
            $('#pagecounter').html('Frage ' + parseInt(myStartFrage + 1) + ' von ' + myVar.fragen.length);
        }

        myinitbody = function(inFrage) {
            $('#headline').html(myVar.fragen[inFrage].theme);
			if(myVar.fragen[inFrage].additionalHTML) {
				$('#additionalHTML').html(myVar.fragen[inFrage].additionalHTML);
			}
			else {
				$('#additionalHTML').html("");
			}
            document.title = myVar.fragen[inFrage].theme;
            showCounts();

            //console.log(myVar);

            if (parseInt(myStartFrage + 1) >= myVar.fragen.length) {
                //	alert(parseInt(myStartFrage + 1));
                if (!isEditable) {

                    $('#link_next').addClass("disabled");

                }
            }


            $('#head').html(myVar.fragen[inFrage].head);
            $('#headwrite').val(myVar.fragen[inFrage].head);
            $('#body').html("");

            //	console.log(myVar.fragen[inFrage].body);

            $('#alert').html(myVar.fragen[myStartFrage].hint);
            $('#ok').html(myVar.fragen[myStartFrage].ok);


            myChoiceClass = "";
            myTextareaClass = "";
            // Wenn Antwortmöglichkeiten vorgeben
            if (myVar.fragen[inFrage].elements == "text") {
                myChoiceClass = "myHidden";

            }
            if (myVar.fragen[inFrage].elements == "choice") {
                myTextareaClass = "myHidden";

            }

            $.each(myVar.fragen[inFrage].choice, function(k, v) {



                //Bei Bedarf wieder aktivieren
                //  if (v && v.length - 1 >= 0) {
                //alert(v);
                //console.log(v.length);

                myAppend = $('#body').append('<li class="list-group-item myChoice ' + myChoiceClass + '">\
                                <div class="checkbox">\
                                    <label>\
                                        <input type="checkbox" value="' + k + '"> <span  class="myReadable"> ' + v + '</span>\
                                    <input class="myEditable" size="26" type="text" myvalue="' + k + '" value="' + v + '"></label>\
                                </div>\
                            </li>');
                //    }




            });

           


            myAppend = $('#body').append('<li class="list-group-item  myTextarea ' + myTextareaClass + '">\
                                <div >\
                                            <textarea myvalue="text" class="text" rows="2" ></textarea>\
                                  </div>\
								  </li>');
								  
			  if(isEditable) {
				 $('.myEditable').show();
				 $('.myReadable').hide();
			 }					  

            $('#button').prop('disabled', false);


            $(':checkbox').css('transform', 'scale(1.5)');

            if (isEditable) {
                $('[value="' + myVar.fragen[myStartFrage].solution + '"]').prop('checked', true);
            }


            $('#body .list-group-item').click(function(e) {
                /* alert('li');
         if(isEditable == true && directcheck == false ) {
		 
		 e.preventDefault(); 
		 return false;
		 }*/
                if (mydisabled == true) {
                    $('#button_renew').click();
                }
            });

            $('#body label span').click(function(e) {
                if (isEditable == true) {
                    e.preventDefault();
                }
            });

            $(':checkbox').change(function() {

                if (mydisabled == false) {
                    $('#button').prop('disabled', false);
                    //  e.preventDefault();	
                    $(this).siblings(':first').focus();

                    //CiMTODO
                    if (myVar.fragen[inFrage].choicetype == "question" || myVar.fragen[inFrage].choicetype == "survey") {
                        myCheckbox = $(this);
                        $(':checkbox').each(function() {
                            if ($(this).attr('value') != myCheckbox.attr('value') || isEditable == false) {
                                $(this).prop('checked', false);
                            }
                        });

                        if (isSurvey == false || isEditable == false) {
                            $(this).prop('checked', true);
                        }
                    } else {
                        if ($(this).find('[type="checkbox"]').prop('checked') == true) {
                            $(this).find('[type="checkbox"]').prop('checked', false);
                        } else {
                            $(this).find('[type="checkbox"]').prop('checked', true);
                        }

                    }
                }



            });
            /*   $('#body').find('[type="checkbox"]').each(function() {
		 $(this).click(function(e){
		// alert($(this).prop('checked'));
		 });
		 
		 }); */
            /* $('#body').find('.list-group-item').each(function(){$(this).click(function(e) {
         return false;
		 if (mydisabled==false){
            $('#button').prop('disabled',false);
         e.preventDefault();	
           
         if (myVar.fragen[inFrage].type == "radio") {
         $('#body').find('[type="checkbox"]').each(function() {
         $(this).prop('checked',false);
         }); 
         $(this).find('[type="checkbox"]').prop('checked',true);
         }
         else {
         if ($(this).find('[type="checkbox"]').prop('checked') == true) {
         	$(this).find('[type="checkbox"]').prop('checked',false);
         } else {$(this).find('[type="checkbox"]').prop('checked',true);}
         }
         
         	
         
         }})});*/




            if (isEditable) {
                $('.CE').prop("contentEditable", true);
                setKeyDowns($('#body'));

            }

            $('#head').html(myVar.fragen[inFrage].head);
        }
        //ENDE myinitbody


        setKeyDowns = function(node) {
            node.bind('keydown', function(event) {
                if (event.ctrlKey || event.metaKey) {
                    switch (String.fromCharCode(event.which).toLowerCase()) {
                        case 'l':
                            event.preventDefault();
                            createEncodedLink();
                            break;
                        case 's':
                            event.preventDefault();
                            saveQuestion();
                            break;
                        case 'n':
                            event.preventDefault();
                            newQuestion();
                            break;

                    }
                }
            });

        }
function checkIfSuperUser() {
	// $('#clicklink').parent().show();
	if (getUrlParameter("setsuperuser")) {
                localStorage.setItem('superuser', true);
                //  alert(getUrlParameter("setsuperuser"));
            }
	if (getUrlParameter("unsetsuperuser")) {
                localStorage.setItem('superuser', false);
                //alert('ok');
            }
            superuser = localStorage.getItem('superuser') == "true";


            if (superuser == true) {

                $('#clickedit').parent().show();
               
                $('#clicksorting').parent().show();
                $('#clickresults').parent().show();
				$('#clicksave').parent().show();
            }
}
		
 function convertMultilineJSON(json) {
	 var myreturn = json;
	
	  //Handelt es sich um ein Array?
					if (json[1]) {
						myreturn = {"fragen":[]};
						
						$.each(json, function(k,v) {
							
							$.each(v.fragen, function(k1,v1) {
								
							myreturn.fragen.push(v1);	
							} );
							
						}); 
						
						
						}
						else {
							
						checkIfSuperUser();	
					
						}
		
		
		return myreturn;				
 }
		
        $(document).ready(function() {




            myinit();
			
		

            

            if (getUrlParameter("unsetsurvey")) {
                isSurvey = false;
            }

            

         

            if (getUrlParameter("code")) {
                $.getJSON("./getText.php?code=" + getUrlParameter("code")+ '&ts=' + Date.now(), function(json) {
                    code = getUrlParameter("code");

                    $('.qr-code').attr('src', $('.qr-code').attr('src') + code);
                   

				   
					myVar = convertMultilineJSON(json);
				




                    // createEncodedLink();
                    isEditable = false;
                    $('.CE').prop("contentEditable", false);
                    $('#alert,#ok').hide();
                    getLSCounter(myVar.id);
                    mysetCounter(myCounter, myOK, myNOK);
                    myinit();
                    myinitbuttons();
                    myinitbody(myStartFrage);




                }).fail(function(error) {
                    console.log("Es ist ein Fehler aufgetreten. Es wird ein Datensatz " + code + " erzeugt.");
                    code = getUrlParameter("code");
                    $.post("./create.php", {
                        "code": code,
                        "text": JSON.stringify(myVar)
                    });



                    $('.qr-code').attr('src', $('.qr-code').attr('src') + code);

                    // createEncodedLink();
                    isEditable = false;
                    $('.CE').prop("contentEditable", false);
                    $('#alert,#ok').hide();
                    getLSCounter(myVar.id);
                    mysetCounter(myCounter, myOK, myNOK);
                    myinit();
                    myinitbuttons();
                    myinitbody(myStartFrage);

                });
            } else if (getUrlParameter("class")) {

                $.getJSON("./getjsonbyclass.php?class=" + getUrlParameter("class"), function(json) {
                    localStorage.setItem("myclass", getUrlParameter("class"));
                    $('#mymodal2').modal('show');
                    $('#mymodal2').find('.modal-title').html('Wählen Sie einen Test aus');

                    $.each(json.jsons, function(k, v) {
                        //console.log(v.code);
                        $('#mymodal2').find('.modal-body').append('<li style="list-style-type:none"><a href="./index.html?code=' + v.code + '">' + v.title + '</a></li>');

                    });

                    /*   $('#mymodal2').find('.modal-body').html('  <div class="input-group">\
  <input type="text" class="form-control" placeholder="[Kürzel]-[Klasse]-[Nr]">\
  <div class="input-group-btn">\
    <button type="button" class="btn btn-default ">OK</button>\
  </div>\
</div>\
	'); */
                });
            } else if (localStorage.getItem("myclass")) {
                window.location.href = "./index.html?class=" + localStorage.getItem("myclass");

            } else {

                $('#mymodal2').modal('show');
                $('#mymodal2').find('.modal-title').html('Bitte geben Sie den Code ein');
                $('#mymodal2').find('.modal-body').html('  <div class="input-group">\
  <input type="text" class="form-control" placeholder="[Kürzel]-[Klasse]-[Nr]">\
  <div class="input-group-btn">\
    <button type="button" class="btn btn-default ">OK</button>\
  </div>\
</div>\
');

                $('#mymodal2 button').click(function() {
                    if ($('#mymodal2 input').val().length > 1) {
						checkIfSuperUser();
                        var mytext = window.location.href;
                        mytext = mytext.replace(/\[?|&]*code=.*&*/g, '');

                        myParams = mytext.replace(/.*\?/, '&');
                        //alert(myParams);
                        if (myParams == window.location.href) {
                            myParams = "";
                        }

                        window.location.href = mytext.replace(/\?.*/, '') + '?code=' + $('#mymodal2 input').val() + myParams;
                    } else {
                        window.location.href = window.location.href;
                    }

                    /*if (mytext == window.location.href) {
	mytext = mytext + '?code='+$('#mymodal2 input').val();
	}
    mytext = mytext.replace(/\?\?/g,'?');
window.location.href = mytext; */

                });

            }




            if (getUrlParameter("encoded")) {
                isEditable = false;

                //  console.log(atob(getUrlParameter("encoded")));
                myVar = JSON.parse(atob(getUrlParameter("encoded")).trim());
                // console.log(atob(JSON.stringify(myVar)));
                getLSCounter(myVar.id);
                mysetCounter(myCounter, myOK, myNOK);
                myinit();
                myinitbuttons();
                myinitbody(myStartFrage);
                // $('.CE').prop("contentEditable",true);


            }



            ///Click

        }); //Document.ready
    </script>
</head>

<body style="margin:0px; font-size:18px;">




    <div id="mymodal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                </div>

                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>


    <div id="mymodal2" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="mymodal2message">New message</h4>
                </div>

                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>


    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active" title="Onlinetest"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" id="clickhome"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span></a></li>
            <li role="presentation" title="Druckversion"><a href="#offlinearea" aria-controls="profile" role="tab" data-toggle="tab" id="offlineversion"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
            <li role="presentation" style="display:none" title="Sortierung der Fragen"><a href="#sorting" aria-controls="profile" role="tab" data-toggle="tab" id="clicksorting"><span class="glyphicon glyphicon-sort" aria-hidden="true"></span></a></li>
            <li role="presentation" ><a href="#linktab" aria-controls="messages" role="tab" data-toggle="tab" id="clicklink"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a></li>
            <li role="presentation" style="display:none"><a href="#edit" aria-controls="settings" role="tab" title="Test editieren" id="clickedit"><span class="glyphicon glyphicon-pencil" mystatus="inactive" style="color:lightgrey" aria-hidden="true"></span></a></li>
            <li role="presentation" style="display:none"><a href="#offlinearea" aria-controls="settings" role="tab" data-toggle="tab" title="Antworten anzeigen" id="clickresults"><span class="glyphicon glyphicon-list"   aria-hidden="true"></span></a> </li>
			<li role="presentation" style="display:none" title="Speichern"><a  aria-controls="profile" role="button"  id="clicksave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></a></li>
		
		</ul>




        <!-- Tab panes -->
        <div class="tab-content container">
            <div role="tabpanel" class="tab-pane active" id="home">


                <div id="onlinearea" style="min-height:800px; margin-top: 0px;">
                    <p class="navbar-text navbar-right counter"><span class="badge" title="Versuche"><span class=" glyphicon glyphicon-asterisk"  ></span> <span id="counter">0</span></span>
                        <span class="badge" title="Treffer"><span class=" glyphicon glyphicon-ok"  ></span><span id="counter_ok">0</span></span>
                        <span class="badge" title="Patzer"><span class=" glyphicon glyphicon-remove" ></span><span id="counter_nok">0</span></span>
                    </p>
                    <div class="page-header" style="margin-top:0px;">



                        <h1><span id="headline" class="CE"> Fragen erfassen</span>



                        </h1>



                    </div>




                    <!-- Poll - START -->

                    <nav aria-label="...">
                        <ul id="pager" class="pager">
                            <li id="link_previous" class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> </a></li>
                            <li id="pagecounter" class="small"><span>Frage 1/1</span></a>
                            </li>
                            <li id="link_next" class="next"><a href="#"> <span aria-hidden="true">&rarr;</span></a></li>
                        </ul>
                    </nav>

                    <div class="qbox">

                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading myReadable">
                                    <h3 class="panel-title" style="font-size:18px;"> <span id="head">Please Rate our service</span></h3>

                                </div>
                                <div class="panel-heading myEditable">
                                    <h3 class="panel-title" style="font-size:18px;"> <textarea id="headwrite" value="" cols="30" rows="2"> </textarea> </h3>
									
                                </div>
								<div class="CE" style="text-align:center" id="additionalHTML"></div>
                                <div style="text-align:center">
                                    <div id="elementswitch" class="btn-group myHidden">
                                        <button type="button" class="btn btn-secondary" mytype="choice">Auswahl</button>
                                        <button type="button" class="btn btn-secondary" mytype="text">Text</button>
                                        <button type="button" class="btn btn-secondary" mytype="both">Beides</button>
                                    </div>
                                </div>


                                <div class="panel-body">
                                    <ul id="body" class="list-group">
                                        <li class="list-group-item">
                                            <div class="checkbox">
                                                <label>
                              <input type="checkbox" value="a" > <span class="CE"> Excellent</span>
                                        </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="checkbox">
                                                <label>
                              <input type="checkbox" value="b" >  <span class="CE"> Good </span>
                              </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="checkbox">
                                                <label>
                              <input type="checkbox" value="c" > <span class="CE">Satisfactory </span>
                              </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="checkbox">
                                                <label>
                              <input type="checkbox" value="d">  <span class="CE">Needs Improvement</span>
                              </label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <br/>
                                <div id="alert" class="alert alert-danger CE" style="text-align:center; display:none;">...</div>
                                <div id="ok" class="alert alert-success CE" style="text-align:center;" style="display:none; visibility:hidden">...</div>
                                <div id="next" class="panel-footer text-center" style="display:none">
                                    <button id="button_next" type="button" class="btn btn-warning btn-block ">
                     Nächste Frage</button>
                                </div>
                                <div id="again" class="panel-footer text-center" style="display:none">
                                    <button id="button_renew" type="button" class="btn btn-warning btn-block ">
                     Nochmal</button>
                                </div>
                                <div class="panel-footer text-center">
                                    <button id="button" type="button" class="btn btn-primary btn-block ">
                     antworten</button>
                                    <br/>
                                    <!-- <a id="restart" href="#" class="small" >Neustart</a> -->
                                </div>

                                <div id="mydebug"></div>
                                <!-- <a href="#" name="emailLink" id="emailLink">Email</a> -->
                            </div>
                        </div>


                    </div>


                    <style>
                        .counter {

                            margin-right: 0px !important;
                        }

                        .container {
                            margin: none;
                        }

                        body {
                            margin-top: 20px;

                        }

                        span.CE {
                            margin-left: 5px;
                        }

                        .panel-body:not(.two-col) {
                            padding: 0px;
                        }

                        .glyphicon {
                            margin-right: 5px;
                        }

                        /* .glyphicon-new-window {
            margin-left: 5px;
            } */

                        .panel-body .radio,
                        .panel-body .checkbox {
                            margin-top: 0px;
                            margin-bottom: 0px;
                        }

                        .panel-body .list-group {
                            margin-bottom: 0;
                        }

                        .margin-bottom-none {
                            margin-bottom: 0;
                        }

                        .panel-body .radio label,
                        .panel-body .checkbox label {
                            display: block;
                        }

                        [contentEditable="true"] {
                            /*   background-color: lightgrey; */
                            border: 1px solid #ccc;
                            border-radius: 0px;
                            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                        }



                        body.dragging,
                        body.dragging * {
                            cursor: move !important;
                        }

                        .dragged {
                            position: absolute;
                            opacity: 0.5;
                            z-index: 2000;
                        }

                        ol.example li.placeholder {
                            position: relative;
                            /** More li styles **/
                        }

                        ol.example li.placeholder:before {
                            position: absolute;
                            /** Define arrowhead **/
                        }



                        .nosolution {

                            display: none;
                        }

                        .placeholder {
                            display: inline-block;
                            width: 24px;
                        }

                        h4 {
                            font-weight: bold;
                        }

                        .myHidden {
                            display: none;
                        }

                        .btn:hover {
                            background-color: grey;
                        }

                        .myEditable {
                            display: none;
                        }

                        #headwrite {
                            color: black;
                        }
						span.myReadable {
							padding-left:0.4em;
						}
						a {
							cursor:pointer;
						}
						#additionalHTML img {
							width:95%;
							
						}
						#additionalHTML {
							min-height: 0.2em;
						}
                    </style>
                    <!-- Poll - END -->
                </div>





            </div>


            <div role="tabpanel" class="tab-pane" id="offlinearea">
                <div class="container" style=" margin-top: 0px;" id="offlinetext"></div>
                <!--<div class="container" style=" margin-top: 0px;"><img class="qr-code" src="http://qrickit.com/api/qr?d=http://k1-cptools.rhcloud.com/index.html?code=" /> </div> -->
            </div>


            <div role="tabpanel" class="tab-pane" id="sorting">
                <div class="container" id="sortingbody" style=" margin-top: 0px;">
                </div>
            </div>


            <div role="tabpanel" class="tab-pane" id="linktab">
                <div class="container" style=" margin-top: 0px;" id="linkText"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">...</div>
        </div>

    </div>

	


</body>

</html>