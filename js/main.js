 function getJSON(path, success, error)
    {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
        {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    if (success)
                        success(JSON.parse(xhr.responseText));
                } else {
                    if (error)
                        error(xhr);
                }
            }
        };
        xhr.open("GET", path, true);
        xhr.send();
    }

    Date.prototype.ddmmyyyy = function (lit) {
        lit = (lit===undefined) ? '.' : lit;
        let mm = this.getMonth() + 1; 
        let dd = this.getDate();
        return [(dd>9 ? '' : '0') + dd, (mm>9 ? '' : '0') + mm, this.getFullYear()].join(lit);
    };

    getJSON( "/data/data.json", function( json ) {
	    let plans = json.tarifs;
        const index = {
            template : "#page1", props: ['plans']
        };
        const step2 = {
            template : "#page2", props: ['plans']
        };
        const step3 = {
            template : "#page3", props: ['plan','today']
        };
        const vueRouter = new VueRouter({ 
      	base: '/',
			routes: [
                { path:"/", component: index, props: {plans:plans}, },
                { path:"/:id", component: step2, props: {plans:plans}  },
                { path:"/:id/:i", component: step3, props: (route) => ({ plan: plans[route.params.id].tarifs[route.params.i], today: new Date() }) }
            ]
        });
	    const app = new Vue({
		    el:"#app",
            router: vueRouter
        })
    });