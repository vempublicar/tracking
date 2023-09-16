<html>
<style TYPE="text/css">
    body {
        background-color: rgba(128,128,128,0.0);
    }
</style>
    <body>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
            <a onclick="abrirWhatsapp();" 
            style="
            position:fixed;
            width:25%;
            height:40px;
            bottom:7px;
            right:7px;
            border-radius: 10px;
            background-color:#25d366;
            color:#FFF;
            text-align:center;
            font-size:30px;
            box-shadow: 1px 1px 2px #888;
              z-index:1000;" target="_blank">
            <i style="margin-top:5px" class="fa fa-whatsapp"></i>
            </a>
    </body>
</html>
<script>
    function abrirWhatsapp(){
        var destino = "Qy1TUDgwMDMzLTQtQQ";
        var log_campanha = localStorage.getItem('p_tck');
        var log_ultimo = localStorage.getItem('u_tck');
        var log_key = localStorage.getItem('k_tck');
        const array = document.URL.split('#');
        var campanha = array[1];
        var idCliente = array[0];
        var url = "https://vf.app.br/whatsapp/"+destino+'/'+log_campanha+'/'+log_ultimo+'/'+log_key;

        var win = window.open(url, '_blank');
        win.focus();

    }
    

</script>
                
                  