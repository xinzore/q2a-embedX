<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// theme replacement functions

		function head_custom()
		{
			qa_html_theme_base::head_custom();
			if(qa_opt('embed_enable_thickbox')) { 
				$this->output('<script type="text/javascript" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'dist/js/lightbox-plus-jquery.js"></script>');
				$this->output('<link rel="stylesheet" href="'.QA_HTML_THEME_LAYER_URLTOROOT.'dist/css/lightbox.css" type="text/css" media="screen" />');
				
			}
		}
		function head_css() // add a FontAwesome CSS file from plugin CDN
		{
				$this->output('<link href="'.QA_HTML_THEME_LAYER_URLTOROOT.'qa-embed.css" rel="stylesheet">');

				parent::head_css();
		}
		function q_view_content($q_view)
		{
			if (isset($q_view['content'])){
				$q_view['content'] = $this->embed_replace($q_view['content']);
			}
			qa_html_theme_base::q_view_content($q_view);
		}
		function a_item_content($a_item)
		{
			if (isset($a_item['content'])) {
				$a_item['content'] = $this->embed_replace($a_item['content']);
			}
			qa_html_theme_base::a_item_content($a_item);
		}
		function c_item_content($c_item)
		{
			if (isset($c_item['content'])) {
				$c_item['content'] = $this->embed_replace($c_item['content']);
			}
			qa_html_theme_base::c_item_content($c_item);
		}

		function embed_replace($text) {
			
			$w2 = qa_opt('embed_image_width');
			
			$h2 = qa_opt('embed_image_height');
			
			$types = array(
				'youtube'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*youtube\.com\/watch\?\S*v=([A-Za-z0-9_-]+)[^< ]*',
						'<div class="videoWrapper"><iframe width="560" height="349" src="https://www.youtube.com/embed/$1?wmode=transparent" frameborder="0" allowfullscreen></iframe></div>'
					),
					array(
						'https{0,1}:\/\/w{0,3}\.*youtu\.be\/([A-Za-z0-9_-]+)[^< ]*',
						'<div class="videoWrapper"><iframe width="560" height="349" src="https://www.youtube.com/embed/$1?wmode=transparent" frameborder="0" allowfullscreen></iframe></div>'
					),
					array(
						'https{0,1}:\/\/m\.*youtube\.com\/watch\?\S*v=([A-Za-z0-9_-]+)[^< ]*',
						'<div class="videoWrapper"><iframe width="560" height="349" src="https://www.youtube.com/embed/$1?wmode=transparent" frameborder="0" allowfullscreen></iframe></div>'
					)
				),
				'facebook'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*facebook\.com\/watch\/?\S*v=([0-9]+)[^< ]*',
						'<div class="videoWrapper"><iframe src="https://www.facebook.com/plugins/post.php?href=https://www.facebook.com/watch/?v=$1" width="500" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe></div>'
					),
					array(
						'https{0,1}:\/\/w{0,3}\.*facebook\.com\/([A-Za-z0-9_-]+)\/videos\/([0-9]+)[^< ]*',
						'<div class="videoWrapper"><iframe src="https://www.facebook.com/plugins/post.php?href=https://www.facebook.com/$1/videos/$2" width="500" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe></div>'
					),
					array(
						'https{0,1}:\/\/w{0,3}\.*facebook\.com\/([A-Za-z0-9_-]+)\/posts\/([0-9]+)[^< ]*',
						'<div><iframe src="https://www.facebook.com/plugins/post.php?href=https://www.facebook.com/$1/posts/$2" width="370" height="370" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe></div>'
					),
					array(
						'https{0,1}:\/\/w{0,3}\.*fb\.watch\/([A-Za-z0-9_-]+)[^< ]*',
						'<div class="videoWrapper"><iframe src="https://www.facebook.com/plugins/video.php?href=https://fb.watch/$1&width=500&show_text=false&height=282&appId" width="500" height="282" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe></div>'
					)
				),
				'vimeo'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*vimeo\.com\/([0-9]+)[^< ]*',
						'<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/$1?h=af378d745c&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>')
				),
				'tiktok'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*tiktok\.com\/@([A-Za-z0-9_-]+)\/video\/([0-9]+)[^< ]*',
						'<blockquote class="tiktok-embed" cite="https://www.tiktok.com/@$1/video/$2" data-video-id="$2" style="max-width: 605px;min-width: 325px;" > <section></section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>'
					)
				),
				'webtor'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*webtor\.io\/([A-Za-z0-9_-]+)[^< ]*',
						'<video width="100%" controls src="magnet:?xt=urn:btih:$1&dn="></video><script src="https://cdn.jsdelivr.net/npm/@webtor/player-sdk-js/dist/index.min.js" charset="utf-8" async></script>'
					)
				),
				'twitter'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*twitter\.com\/([A-Za-z0-9_-]+)[^< ]*',
						'<blockquote class="twitter-tweet" data-lang="tr" data-theme="dark"><p lang="sv" dir="ltr"></p><a href=https://twitter.com/$0 </a></blockquote><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>'
					)
				),
				'instagram'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*instagram\.com\/([A-Za-z0-9_-]+)[^< ]*',
						'<blockquote class="instagram-media" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="$0" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">Bu gönderiyi Instagram&#39;da gör</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"> style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank"></a></p></div></blockquote> <script async src="//www.instagram.com/embed.js"></script>'
					)
				),
				'strawpoll'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*strawpoll\.com\/polls\/([A-Za-z0-9]+)[^< ]*',
						'<div class="strawpoll-embed" id="strawpoll_$1" style="height: 580px; max-width: 640px; width: 100%; margin: 0 auto; display: flex; flex-direction: column;"><iframe title="StrawPoll Embed" id="strawpoll_iframe_$1" src="https://strawpoll.com/embed/polls/$1" style="position: static; visibility: visible; display: block; width: 100%; flex-grow: 1;" frameborder="0" allowfullscreen allowtransparency>Loading...</iframe><script async src="https://cdn.strawpoll.com/dist/widgets.js" charset="utf-8"></script></div>'
					)
				),
				'dailymotion'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*dailymotion\.com\/video\/([A-Za-z0-9]+)[^< ]*',
						'<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;"> <iframe style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden" frameborder="0" type="text/html" src="https://www.dailymotion.com/embed/video/$1" width="100%" height="100%" allowfullscreen > </iframe> </div>'
					)
				),
				'image'=>array(
					array(
						'(https*:\/\/[-\%_\/.a-zA-Z0-9+]+\.(png|jpg|jpeg|gif|bmp))[^< ]*',
						'<img src="$1" style="max-width:'.$w2.'px;max-height:'.$h2.'px" />','img'
					)
				),
				'mp4'=>array(
					array(
						'(https*:\/\/[-\%_\/.a-zA-Z0-9]+\.mp4)[^< ]*',
						'<div><video width="100%" class="zort" controls><source src="$1" type="video/mp4">Your browser does not support HTML video.</video></div>'
					)
				),
				'mp3'=>array(
					array(
						'(https*:\/\/[-\%_\/.a-zA-Z0-9]+\.mp3)[^< ]*',qa_opt('embed_mp3_player_code'),'mp3'
					)
				),
				'gmap'=>array(
					array(
						'(https*:\/\/maps.google.com\/?[^< ]+)',
						'<iframe width="'.qa_opt('embed_gmap_width').'" height="'.qa_opt('embed_gmap_height').'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="$1&amp;ie=UTF8&amp;output=embed"></iframe><br /><small><a href="$1&amp;ie=UTF8&amp;output=embed" style="color:#0000FF;text-align:left">View Larger Map</a></small>','gmap'
					)
				),
			);

			foreach($types as $t => $ra) {
				foreach($ra as $r) {
					if( (!isset($r[2]) && !qa_opt('embed_enable')) || (isset($r[2]) && !qa_opt('embed_enable_'.$r[2])) ) continue;
					
					if(isset($r[2]) && @$r[2] == 'img' && qa_opt('embed_enable_thickbox') && preg_match('/MSIE [5-7]/',$_SERVER['HTTP_USER_AGENT']) == 0) {
						preg_match_all('/'.$r[0].'/',$text,$imga);
						if(!empty($imga)) {
							foreach($imga[1] as $img) {
								$replace = '<a href="'.$img.'" data-lightbox="xinzore" class="thickbox"><img  src="'.$img.'" style="max-width:'.$w2.'px;max-height:'.$h2.'px" /></a>';
								$text = preg_replace('|<a[^>]+>'.$img.'</a>|i',$replace,$text);
								$text = preg_replace('|(?<![\'"=])'.$img.'|i',$replace,$text);
							}
						}
						continue;
					}
					$text = preg_replace('/<a[^>]+>'.$r[0].'<\/a>/i',$r[1],$text);
					$text = preg_replace('/(?<![\'"=])'.$r[0].'/i',$r[1],$text);
				}
			}
			return $text;
		}
	}
