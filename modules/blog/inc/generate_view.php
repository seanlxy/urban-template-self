<?php

if( !empty($posts_arr) )
{
	foreach ($posts_arr as $post)
	{
		$description  		= $post['description'];
		$short_description  = $post['short_description'];
		$blog_full_url		= $pg_full_url.$post['full_url'];
		$blog_heading 		= ((!$is_single) ? '<h2 class="blog__item__heading"><a href="'.$blog_full_url.'" title="'.$post['title'].'" class="btn--link btn--link-blue">'.$post['heading'].'</a></h2>' : '');
		
		if( !$is_single ){
			$ending       = '...';
			$description  = nl2br($short_description);
			$description  = str_truncate($short_description, 250, $ending, true, true);
			$description .= '<br><a href="'.$pg_full_url.$post['full_url'].'" title="'.$post['title'].'" class="btn btn-blue read-more-link">Read More</a>';

		}
		if( $is_single ){
			$posts_view .= <<<HTML
			 <article class="col-xs-12 blog-entry">
				{$blog_heading}
				<p><img src="{$post['photo_path']}" alt="{$post['title']}" title="{$post['title']}" style="width:100%"></p>
				<div>{$description}</div>
				<p class="author">
					<i class="fa fa-clock-o"></i> 
					Posted by <a href="{$pg_full_url}/author/{$post['author_url']}" class="btn--link btn--link-blue blog__link">{$post['author_name']}</a> on {$post['posted_on']}</p>
			</article>
HTML;
		}
		else
		{
			if($post['thumb_photo_path']){

				$posts_view .= <<<HTML
				 <article class="col-xs-12 blog__item">
				 	<div class="blog__image"  title="{$post['title']}">
				 		<a href="{$blog_full_url}" title="{$post['title']}">
				 		 	<span style="background-image:url({$post['thumb_photo_path']})"></span>
				 		</a>
				 	</div>
				 	<div class="blog__content">
				 		{$blog_heading}
				 		<p class="author">
							<i class="fa fa-clock-o"></i> 
							Posted by <a href="{$pg_full_url}/author/{$post['author_url']}" class="blog__link">{$post['author_name']}</a> on {$post['posted_on']}</p>
						<div>{$description}</div>
				 	</div>				
				</article>
HTML;
			}else{
				
				$posts_view .= <<<HTML
				 <article class="col-xs-12 blog__item">
				 	<div class="blog__image"  title="{$post['title']}" style="display: none;"">
				 		<a href="{$blog_full_url}" title="{$post['title']}">
				 		 	<span style="background-image:url({$post['thumb_photo_path']})"></span>
				 		</a>
				 	</div>
				 	<div class="blog__content">
				 		{$blog_heading}
				 		<p class="author">
							<i class="fa fa-clock-o"></i> 
							Posted by <a href="{$pg_full_url}/author/{$post['author_url']}" class="blog__link">{$post['author_name']}</a> on {$post['posted_on']}</p>
						<div>{$description}</div>
				 	</div>				
				</article>
HTML;
			}
		}
	}
}
?>