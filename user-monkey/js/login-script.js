/*
 * This section does not let the user proceed to log in
 * if there is an empty field, or obvious mistake.
 */

//Check username and password are not empty
$(document).ready(function(){
    $('form[name=logIn]').submit(function() {
        var valid = true;
        $("form[name=logIn] input[type=text], form[name=logIn] input[type=password]").each(function() {
            if(this.value==""){
                $(this).css("border","1px solid red");
                alert($(this).attr('placeholder')+" can not be empty");
                valid = false;
            }
        });
        return valid;

    });
});

//Show the stay signed in box, once in password field
$(document).ready(function(){
    $('form[name=logIn]').children('input[name=password]').keyup(function() {
        if ($('form[name=logIn] input[name=username]').val() != '' && $('input[name=password]').val() != ''){
            $("form[name=logIn] p#userOps").text('Stay Signed In?').removeClass('click forgot-lnk');
            $("form[name=logIn] input[name=staySignedIn]").fadeIn('fast'); }
        else {
            $("form[name=logIn] p#userOps").text('Forgot Password?').addClass('click forgot-lnk');
            $("form[name=logIn] input[name=staySignedIn]").fadeOut('fast');
        }
    });
});

//Show password reset option
$('#userOps').click(function(){
    if($(this).hasClass('forgot-lnk')){
    $('#passwordRequired').fadeOut();
    $('#iForgotMyPassword').delay(250).fadeIn();}
})

$('#iRememberItNow').click(function(){
    $('#iForgotMyPassword').fadeOut();
    $('#passwordRequired').delay(250).fadeIn();
})






/*
 * The next section validates the users input as they type it
 * Informs them of anything invalid/ borderline
 * Doesn't let them proceed if there is anything wrong
 */


var element = "";

//Tell the user what the point of each field in the sign up screen is
$("#suUsername").focus(function(){ setDescriptionOfField("The username will be your display name");  });

$("#suEmail").focus(function(){
    setDescriptionOfField("Email used only for password recovery");
});

$("#suPassword").focus(function(){
    setDescriptionOfField("Password will be used to log in");
});

$("#suConfPassword").focus(function(){
    setDescriptionOfField("Confirm the password you typed above");
});

//Remove field description on blur
$("form[name=signUp] input").blur(function(){
    $('#fieldDescription').text("");
});

//Validate the username as they type it
$('form[name=signUp] input#suUsername').keyup(function() {
    if($('input#suUsername').val().length < 2){
        setDescriptionOfField("Your username must be at least 3 characters"); }
    else if($('input#suUsername').val().length > 20){
        setDescriptionOfField("Your username is too long");}
    else { setDescriptionOfField(""); }
});

//Validate the password as they type it
$('form[name=signUp] input#suPassword').keyup(function() {
    if($('input#suPassword').val().length < 6 && $('input#suPassword').val().length > 1){
        setDescriptionOfField("Your Password must be at least 6 characters"); }
    else if($('input#suPassword').val().length > 20){
        setDescriptionOfField("Your password is too long");}
    else { setDescriptionOfField("Password will be used to log in"); }
});

//Validate the username confrimation as they type it
$('form[name=signUp] input#suConfPassword').keyup(function() {
    if($(this).val() != $("input#suPassword").val() && $(this).val().length()>4){
        setDescriptionOfField("Your Passwords must match"); }
    else { setDescriptionOfField("Password confrimation checks you typed it right"); }
});

//Check the username is all cool
$('form[name=signUp]').submit(function() {
    element = "input#suUsername"
    if ($('input#suUsername').val() == '') {
        showFailMessage("Please choose a username", element);
        return false; }
    else if($('input#suUsername').val().length < 2){
        showFailMessage("Username must be atleast 3 characters long", element);
        return false; }
    else if($('input#suUsername').val().length > 20){
        showFailMessage("Username must be under 20 characters long", element);
        return false; }
    else { return true; }
});


//Check the password
$('form[name=signUp], form[name=password-reset]').submit(function() {
    element = "input#suPassword"
    if ($('input#suPassword').val() == '') {
        showFailMessage("Please choose a Password", element);
        return false; }
    else if($('input#suPassword').val().length < 5){
        showFailMessage("Your password should be at least 6 characters", element);
        return false; }
    else if($('input#suPassword').val().length > 25){
        showFailMessage("Password must be under 25 characters", element);
        return false; }
    else { return true; }
});


//Check both the passwords match
$('form[name=signUp], form[name=password-reset]').submit(function() {
    element = "input#suConfPassword"
    if ($('input#suPassword').val() == "") {
        showFailMessage("You must confirm your password", element);
        return false; }
    else if ($('input#suPassword').val() != $('input#suConfPassword').val()) {
        showFailMessage("Your passwords must match", element);
        return false; }
    else { return true; }
});



//Check their email is valid - or looks valid
$('form[name=signUp]').submit(function() {
    element = "input#suEmail"
    if ($('input#suEmail').val() == '') {
        showFailMessage("Please enter your email", element);
        return false; }
    else { return true; }
});


function showFailMessage(message, element){
    $(element).focus();
    $(element).css("border-style","solid");
    $(element).css("border-color","red");
    $(element).css("border-width","1px");
    $('#fieldDescription').text(message);
}

function setDescriptionOfField(newText){
    $('#fieldDescription').text(newText);
}
function clearDescriptionField(){
    $('#fieldDescription').text("");
}






/*
 * @author Alicia Sykes
 */











$("div.grid#logInGrid input").focus(function(){
    $(this).css({'box-shadow' : ' 0 0 6px #E5006F',
        '-webkit-box-shadow':'0 0 6px #E5006F',
        '-moz-box-shadow':'0 0 6px #E5006F'});
    $("div.grid#logInGrid").css({'box-shadow' : ' 0 0 10px #FFBFDE',
        '-webkit-box-shadow':'0 0 10px #FFBFDE',
        '-moz-box-shadow':'0 0 10px #FFBFDE'});
    $("div.grid#logInGrid h2").css({'color':'#F73C93'});
    $("div.grid#logInGrid button").addClass('selected');
});

$("div.grid#logInGrid input").blur(function(){
    $(this).css({'box-shadow'       :'none',
        '-webkit-box-shadow':'none',
        '-moz-box-shadow'   :'none'  });
    $("div.grid#logInGrid").css({'box-shadow' : ' 0 0 5px #FFBFDE',
        '-webkit-box-shadow':'0 0 5px #FFBFDE',
        '-moz-box-shadow':'0 0 5px #FFBFDE'});
    $("div.grid#logInGrid h2").css({'color':'#8E8989'});
    $("div.grid#logInGrid button").removeClass('selected');
});

$("div.grid#signUpGrid input").focus(function(){
    $(this).css({'box-shadow' : ' 0 0 6px #70ED63',
        '-webkit-box-shadow':'0 0 6px #70ED63',
        '-moz-box-shadow':'0 0 6px #70ED63'});
    $("div.grid#signUpGrid").css({'box-shadow' : ' 0 0 10px #70ED63',
        '-webkit-box-shadow':'0 0 10px #70ED63',
        '-moz-box-shadow':'0 0 10px #70ED63'});
    $("div.grid#signUpGrid h2").css({'color':'#41C033'});
    $("div.grid#signUpGrid button").addClass('selected');
});

$("div.grid#signUpGrid input").blur(function(){
    $(this).css({'box-shadow'       :'none',
        '-webkit-box-shadow':'none',
        '-moz-box-shadow'   :'none'  });
    $("div.grid#signUpGrid").css({'box-shadow' : ' 0 0 5px #41C033',
        '-webkit-box-shadow':'0 0 5px #41C033',
        '-moz-box-shadow':'0 0 5px #41C033'});
    $("div.grid#signUpGrid h2").css({'color':'#8E8989'});
    $("div.grid#signUpGrid button").removeClass('selected');
});

$("div.grid#resetPasswordGrid input").focus(function(){
    $(this).css({'box-shadow' : ' 0 0 6px #FF7E21',
        '-webkit-box-shadow':'0 0 6px #FF7E21',
        '-moz-box-shadow':'0 0 6px #FF7E21'});
    $("div.grid#resetPasswordGrid").css({'box-shadow' : ' 0 0 10px #FF7E21',
        '-webkit-box-shadow':'0 0 10px #FF7E21',
        '-moz-box-shadow':'0 0 10px #FF7E21'});
    $("div.grid#resetPasswordGrid h2").css({'color':'#FF7E21'});
    $("div.grid#resetPasswordGrid button").addClass('selected');
});

$("div.grid#resetPasswordGrid input").blur(function(){
    $(this).css({'box-shadow'       :'none',
        '-webkit-box-shadow':'none',
        '-moz-box-shadow'   :'none'  });
    $("div.grid#resetPasswordGrid").css({'box-shadow' : ' 0 0 5px #FF7E21',
        '-webkit-box-shadow':'0 0 5px #FF7E21',
        '-moz-box-shadow':'0 0 5px #FF7E21'});
    $("div.grid#resetPasswordGrid h2").css({'color':'#8E8989'});
    $("div.grid#resetPasswordGrid button").removeClass('selected');
});


$("div.grid#facebookGrid").mouseenter(function(){
    $(this).css({'box-shadow' : ' 0 0 10px #69A3FF',
        '-webkit-box-shadow':'0 0 10px #69A3FF',
        '-moz-box-shadow':'0 0 10px #69A3FF'});
});

$("div.grid#facebookGrid").mouseleave(function(){
    $(this).css({'box-shadow' : ' 0 0 5px #69A3FF',
        '-webkit-box-shadow':'0 0 5px #69A3FF',
        '-moz-box-shadow':'0 0 5px #69A3FF'});
});

$("div.grid#signUpGrid").mouseenter(function(){
    $(this).css({'box-shadow' : ' 0 0 10px #41C033',
        '-webkit-box-shadow':'0 0 10px #41C033',
        '-moz-box-shadow':'0 0 10px #41C033'});
});

$("div.grid#signUpGrid").mouseleave(function(){
    $(this).css({'box-shadow' : ' 0 0 5px #41C033',
        '-webkit-box-shadow':'0 0 5px #41C033',
        '-moz-box-shadow':'0 0 5px #41C033'});
});

$("div.grid#logInGrid").mouseenter(function(){
    $(this).css({'box-shadow' : ' 0 0 12px #FFBFDE',
        '-webkit-box-shadow':'0 0 12px #FFBFDE',
        '-moz-box-shadow':'0 0 12px #FFBFDE'});
});

$("div.grid#logInGrid").mouseleave(function(){
    $(this).css({'box-shadow' : ' 0 0 5px #FFBFDE',
        '-webkit-box-shadow':'0 0 5px #FFBFDE',
        '-moz-box-shadow':'0 0 5px #FFBFDE'});
});

$("div.grid#resetPasswordGrid").mouseenter(function(){
    $(this).css({'box-shadow' : ' 0 0 12px #FF7E21',
        '-webkit-box-shadow':'0 0 12px #FF7E21',
        '-moz-box-shadow':'0 0 12px #FF7E21'});
});

$("div.grid#resetPasswordGrid").mouseleave(function(){
    $(this).css({'box-shadow' : ' 0 0 5px #FF7E21',
        '-webkit-box-shadow':'0 0 5px #FF7E21',
        '-moz-box-shadow':'0 0 5px #FF7E21'});
});


$('input[placeholder], textarea[placeholder]').placeholder();