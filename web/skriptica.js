$(document).ready(function() {

// location.protocol gives http or https
// location.hostname gives hostname
var myUrl = location.protocol + "//" + location.hostname + "/";

    $('button#obrisi').click( function(){
            var id = $(this).attr('data-param');
            var element = $(document).find('div#komentar' + id);
            console.log('div#komentar' + id);
            var data = {"id": id};

            $.ajax({
			url: myUrl + 'obrisi.php',
			dataType: 'json',
			data: JSON.stringify(data),
			type: 'post'
		}).done( function(data){
			var responseStatus = data.status;
            if(responseStatus == 1) {
                element.fadeOut(1000, function(){
                   element.remove();
                });
            } else {
                alert("Nešto je pošlo po zlu!");
            }
		}).fail( function(data){
            alert("Nešto je pošlo po zlu!");
       	});
    });


});