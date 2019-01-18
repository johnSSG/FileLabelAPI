function Filelabel(apiKey, token) {
    this.apiKey = apiKey;
	if(typeof token != undefined) {
		this.token = token;
	}
    this.url = 'https://flx.filelabel.co/api/';
    this.auth = function(callback){
        var that = this;
        var a = new API({
            db:false,
            url:that.url,
            data:{
                action:'auth',
                apiKey:that.apiKey
            },
            success: function(response){
                if(typeof callback == 'function') {
                    that.token = response.output.user.token;
                    callback(response);
                }
            }
        });
    }
    
    this.labelData = function(data, callback){
        var that = this;
        var a = new API({
            db:false,
            url:that.url,
            data:{
                action:'labelData',
                token:that.token,
                data:data
            },
            success: function(response){
                if(typeof callback == 'function') {
                    callback(response);
                }
            }
        });        
    }
};
