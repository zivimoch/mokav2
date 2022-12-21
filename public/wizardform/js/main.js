$(function(){
	$("#wizard").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        transitionEffectSpeed: 300,
        labels: {
            next: "Next",
            previous: "Back"
        },
        onStepChanging: function (event, currentIndex, newIndex) { 
            if ( newIndex === 1 ) {
                $('.steps ul').addClass('step-2');
            } else {
                
                $('.steps ul').removeClass('step-2');
            }
            if ( newIndex === 2 ) {
                $('.steps ul').addClass('step-3');
                $('.actions ul').addClass('mt-7');
            } else {
                $('.steps ul').removeClass('step-3');
                $('.actions ul').removeClass('mt-7');
            }
            if ( newIndex === 3 ) {
                $('.steps ul').addClass('step-4');
                $('.actions ul').addClass('mt-7');
            } else {
                $('.steps ul').removeClass('step-4');
                $('.actions ul').removeClass('mt-7');
            }
            if ( newIndex === 4 ) {
                $('.steps ul').addClass('step-5');
                $('.actions ul').addClass('mt-7');
            } else {
                $('.steps ul').removeClass('step-5');
                $('.actions ul').removeClass('mt-7');
            }
            if ( newIndex === 5 ) {
                $('.steps ul').addClass('step-6');
                $('.actions ul').addClass('mt-7');
            } else {
                $('.steps ul').removeClass('step-6');
                $('.actions ul').removeClass('mt-7');
            }
            if ( newIndex === 6 ) {
                $('.steps ul').addClass('step-7');
                $('.actions ul').addClass('mt-7');
            } else {
                $('.steps ul').removeClass('step-7');
                $('.actions ul').removeClass('mt-7');
            }
            return true; 
        }
    });
    // Custom Button Jquery Steps
    $('.forward').click(function(){
    	$("#wizard").steps('next');
    })
    $('.backward').click(function(){
        $("#wizard").steps('previous');
    })
    // Grid 
    $('.grid .grid-item').click(function(){
        $('.grid .grid-item').removeClass('active');
        $(this).addClass('active');
    })
    // Click to see password 
    $('.password i').click(function(){
        if ( $('.password input').attr('type') === 'password' ) {
            $(this).next().attr('type', 'text');
        } else {
            $('.password input').attr('type', 'password');
        }
    }) 
    // Date Picker
    var dp1 = $('#dp1').datepicker().data('datepicker');
    dp1.selectDate( new Date( ));
})
