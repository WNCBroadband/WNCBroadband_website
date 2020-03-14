$('#downslider').on('input change',function(){
    $('#downtextbox').val($(this).val());
});

$('#downtextbox').keyup(function(e){
      var val = $(this).val().replace(/[^0-9\.]/g, '');  // check only for digits
      $('#downslider').val(val);
});

$('#upslider').on('input change',function(){
    $('#uptextbox').val($(this).val());
});

$('#uptextbox').keyup(function(e){
      var val = $(this).val().replace(/[^0-9\.]/g, '');   // check only for digits
      $('#upslider').val(val);
});