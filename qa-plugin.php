<?php     
           
        if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
                        header('Location: ../../');
                        exit;   
        }               

        qa_register_plugin_module('module', 'qa-embed-admin.php', 'qa_embed_admin', 'Embed Admin');
        
        qa_register_plugin_layer('qa-embed-layer.php', 'Embed Replacement Layer');
                        
                        
/*                              
        Omit PHP closing tag to help avoid accidental output
*/                              
                          

