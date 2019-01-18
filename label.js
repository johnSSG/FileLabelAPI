var label = {
    flx:false,
    
    init: function(){
        label.flx = new Filelabel(user.prefs.apiKey, user.prefs.token);
    },
    
    make: function(t){
        var d = $(t).data();
        var action = 'iframe';
        if(typeof d.labelaction != 'undefined') {
            action = 'newwindow';
        }
        var selected = [];
        $('tbody').find('.selected').each(function(){
            var data = deparam($(this).attr('data-uri'));
            var d = {};
            $.each(data, function(key, value){
                d[key] = value.replace(/(<([^>]+)>)/ig,"");
            });
            selected.push(d);
        });
        if(selected.length) {
            new API({
                db:false,
                url:global.apiUrl,
                data:{
                    action:'labelData',
                    token:user.prefs.token,
                    app:'quantumTracking',
                    data:selected
                },
                success: function(){
                    var url = 'https://flx.filelabel.co/preview?project='+project.id+'&token='+user.prefs.token;
                    if(action == 'iframe') {
                        $('.modal-title').text('Labels');
                        $('#largeModal .modal-body').html('<iframe src="'+url+'">');
                        $('#largeModal').modal('show');
                    } else {
                        window.open(url);
                    }
                }
            });
        }
    }
};
