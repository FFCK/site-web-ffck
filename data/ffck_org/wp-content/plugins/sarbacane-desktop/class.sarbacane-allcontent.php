<?php
class SarbacaneAllContent {
	private function get_rss_header() {
		return '<?xml version="1.0" encoding="UTF-8"?>
	<rss version="2.0"	xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
	<channel>
		<title>' . get_bloginfo_rss ( 'name' ) . '</title>
		<link>' . get_bloginfo_rss ( 'url' ) . '</link>
		<description>' . get_bloginfo_rss ( 'description' ) . '</description>';
	}
	private function get_rss_items($limit) {
		$query = new WP_Query ( array('post_type'=>'post', 'posts_per_page' => $limit) );
		$items = '';
		while ( $query->have_posts () ) :
			$query->the_post ();
			$items .= '<item>
			<title>' . get_the_title_rss () . '</title>
			<link>' . esc_url ( apply_filters ( 'the_permalink_rss', get_permalink () ) ) . '</link>
			<id>' . get_the_ID () . '</id>
			<pubDate>' . mysql2date ( 'D, d M Y H:i:s +0000', get_post_time ( 'Y-m-d H:i:s', true ), false ) . '</pubDate>
			<dc:creator><![CDATA[' . get_the_author () . ']]></dc:creator>
			' . get_the_category_rss ( 'rss2' );
			$items .= '<description><![CDATA[' . apply_filters ( 'the_excerpt_rss', get_the_excerpt () ) . ']]></description>';
			$content = get_the_content_feed ( 'rss2' );
			$items .= '<content:encoded><![CDATA[' . $content . ']]></content:encoded>';
			$items .= '<slash:comments>' . get_comments_number () . '</slash:comments>';
			$media = get_attached_media ( 'image' );
			if ($media != null && sizeof ( $media ) > 0) {
				$all_medias_key = array_keys ( $media );
				$items .= '<enclosure url="' . $media [$all_medias_key [0]]->guid . '" type="' . $media [$all_medias_key [0]]->post_mime_type . '" />';
			}
			$items .= rss_enclosure ();
			do_action ( 'rss2_item' );
			$items .= '</item>';
		endwhile
		;
		return $items;
	}
	private function get_rss_footer() {
		return '</channel></rss>';
	}
	public function get_articles_rss($limit) {
		echo $this->get_rss_header () . $this->get_rss_items ($limit) . $this->get_rss_footer ();
	}
}
