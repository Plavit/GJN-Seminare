$(document).ready(function() {  
  
        //the min chars for username  
        var min_chars = 3;  
  
        //result texts  
        var characters_error = 'Minimum amount of chars is 3';  
        var checking_html = 'Checking...';  
  
        //when button is clicked  
        $('.checkav').click(function(){
            //run the character number check  
            if($('#logmail').val().length < min_chars){
                //if it's bellow the minimum show characters_error text '  
                $('.checkav').html(characters_error);
            }else{  
                //else show the cheking_text and run the function to check  
                $('.checkav').html(checking_html);
                check_availability();  
            }  
        });  
  
  });  
  
//function to check username availability  
function check_availability(){  
  
        //get the username  
        var username = $('#logmail').val();
  
        //use ajax to run the check  
        $.post("check_username.php", { username: username },  
            function(result){  
                //if the result is 1  
                if(result == 1){  
                    //show that the username is available  
                    $('#checkav').html(username + ' is Available');
                }else{  
                    //show that the username is NOT available  
                    $('#checkav').html(username + ' is not Available');
                }  
        });  
  
}  