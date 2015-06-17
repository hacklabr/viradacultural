    <footer id="main-footer" class="clearfix">
        <ul class="sr-only">
            <li>
                Realização
                <ul>
                    <li>Prefeitura de São Paulo - Cultura</li>
                </ul>
            </li>
            <li>
                Parceria
                <ul>
                    <li>Sesc</li>
                    <li>Governo do Estado de São Paulo</li>
                </ul>
            </li>
            <li>
                Produção
                <ul>
                    <li>São Paulo Turismo</li>
                </ul>
            </li>
            <li>
                Patrocínio
                <ul>
                    <li>Petrobras</li>
                    <li>Governo Federal - Brasil - País Rico É País Sem Pobreza</li>
                </ul>
            </li>
        </ul>
        <!--<p class="text-center">
            <?php html::image("logos-990.png", "", array("class" => "img-responsive visible-sm visible-md visible-lg")); ?>
            <?php html::image("logos-320.png", "", array("class" => "img-responsive visible-xs")); ?>
        </p>-->
        <p class="text-center">Desenvolvido por <a id="hacklab" href="http://www.hacklab.com.br" title="hacklab/" target="_blank"><?php html::image("hacklab.png", "Hacklab", array("class" => "hacklab")); ?></a> a partir da API do SP Cultura, instalação do software livre Mapas Culturais, criado em uma parceria entre o <a href="http://institutotim.org.br" title="Instituto TIM" target="_blank"><?php html::image("instituto-tim-white.png", "Instituto TIM", array("class" => "instituto-tim")); ?></a> e a Secretaria Municipal de Cultura</p>
        <p class="text-center">Contato: <a href="mailto:smcimprensa@prefeitura.sp.gov.br">smcimprensa@prefeitura.sp.gov.br</a></p>
    </footer>
    <!-- #main-footer -->
<?php wp_footer(); ?>

<script type="text/html" id="template-lista-de-amigos">

    <% for(var i in friends){ var friend = friends[i]; if(!friend) continue; if(i >= 3) break; %>
        <a href="<?php bloginfo('url') ?>/minha-virada/##<%=friend.uid%>" class="friend" data-toggle="tooltip" title="<%=friend.name%>">
            <!--aqui entra um avatar aleatório ou do último amigo a favoritar esse evento -->
            <img src="<%=friend.picture%>"/>
        </a>
    <% } %>

    <% if(friends.length > 3) { %>
    <a href="<%=eventUrl%>" class="friend" <?php // data-toggle="modal" data-target="#friendsModal" ?> >
        <div <?php //data-toggle="tooltip" data-placement="bottom" ?>>+<%=friends.length - 3%></div>
    </a><!-- link pra modal com lista de todos amigos quando exceder 3 amigos-->
    <% } %>
</script>

<!-- Here is the Open AdStream PCX 2.0 Code  -->
<script type='text/javascript'>
OAS_rn = '001234567890'; OAS_rns = '1234567890';
OAS_rn = new String (Math.random()); OAS_rns = OAS_rn.substring (2, 11);
document.write("<scr"+"ipt type='text/javascript' src='http://de.realmediadigital.com/RealMedia/ads/adstream_jx.ads/pmsp/viradacultural/_on_" + location.hostname + location.pathname + "/1" + OAS_rns +"@x01!x01?'"+"><"+"\/script"+">");
</script>
<!-- Here is the Open AdStream PCX 2.0 Code  -->
</body>
</html>
