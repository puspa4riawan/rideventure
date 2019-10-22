$(document).ready(function(){
    setInterval(function(){
        var tamp_c1 = $('#count1').html();
            tamp_c1 = tamp_c1.replace('.', '');
        var c1 = parseInt(tamp_c1);
        
        var tamp_c2 = $('#count2').html();
            tamp_c2 = tamp_c2.replace('.', '');
        var c2 = parseInt(tamp_c2);
        
        var tamp_c3 = $('#count3').html();
            tamp_c3 = tamp_c3.replace('.', '');
        var c3 = parseInt(tamp_c3);


        get_count(c1, c2, c3);
    },10000);

    
});

function get_count(c1, c2, c3){
    $.ajax({
        type: "POST",
        url: SITE_URL+'home/get_count',
        data: $.extend(tokens,{c1:c1, c2:c2, c3:c3}),
        dataType: 'json',
        success: function(ret){
            if(ret.anim1!=''){
                $('#count1').hide();
                $('#count1').html(ret.count1);
                $('#count1').fadeIn('slow');
            }

            if(ret.anim2!=''){
                $('#count2').hide();
                $('#count2').html(ret.count2);
                $('#count2').fadeIn('slow');
            }

            if(ret.anim3!=''){
                $('#count3').hide();
                $('#count3').html(ret.count3);
                $('#count3').fadeIn('slow');
            }

            $('#count4').hide();
            $('#count4').html(ret.count4);
            $('#count4').fadeIn('slow');
        },
    });  
}