var log_campanha = localStorage.getItem('p_tck');
var log_ultimo = localStorage.getItem('u_tck');

const array = document.URL.split('#');
var campanha = array[1];
var idCliente = array[0];

var data = new Date();
var data_hoje = 'd'+data.getDate() +'m'+ (data.getMonth()+1);
var log_data = localStorage.getItem('d_tck');
var str_sessao = localStorage.getItem('sessao');

if(log_campanha == null ){
    localStorage.setItem ('p_tck', campanha);
}
if(typeof campanha == 'undefined'){
    campanha = 'sem campanha';
}
localStorage.setItem ('d_tck', data_hoje);
localStorage.setItem ('u_tck', campanha);

var url = idCliente+'#'+campanha+'#'+log_campanha+'#'+log_ultimo;
var e = btoa(url.split("#"));

ifrm = document.createElement("IFRAME");
ifrm.setAttribute("src", "https://tracking.vempublicar.com/track/"+e+"");
ifrm.setAttribute("style", "height:50px;width:100%;background:#fff;opacity: 0.6;");
document.body.appendChild(ifrm);

