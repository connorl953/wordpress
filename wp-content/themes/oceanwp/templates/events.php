<?php 

/* Template Name: Events */

get_header();
	
?>

<div class="event-header">
	<img src="/wp-content/uploads/ideas-matter.png" class="desktop" />
	<img src="/wp-content/uploads/mobile-banner-size-414x276.png" class="mobile" />
</div>

<div class="event-intro">
	<div class="event-intro-content">
		<img src="/wp-content/uploads/intro-full-2.png" />
		<a href="/student-registration"><img src="/wp-content/uploads/registration-button.png" class="reg-btn" /></a>
	</div>
</div>

<div class="event-content">
	<img src="/wp-content/uploads/content-top.png" class="border" />
	<div class="event-content-desktop">
		<img src="/wp-content/uploads/event-content-q1.png" class="question" onclick="showAnswer(this)" />
		<img src="/wp-content/uploads/event-content-a1.png" class="answer" style="display:inline-block;" />
		<img src="/wp-content/uploads/event-content-q2.png" class="question" onclick="showAnswer(this)" />
		<img src="/wp-content/uploads/event-content-a2.png" class="answer" style="display:inline-block;" />
		<img src="/wp-content/uploads/event-content-q3.png" class="question" onclick="showAnswer(this)" />
		<img src="/wp-content/uploads/event-content-a3.png" class="answer" style="display:inline-block;" />
		<a href="/partners/"><img src="/wp-content/uploads/event-content-q4.png" class="question" /></a>
	</div>
	<div class="event-content-mobile">
		<img src="/wp-content/uploads/521x2413.png" />
	</div>
	<img src="/wp-content/uploads/content-bottom.png" class="border" />
</div>

<div class="event-callout">
	<div class="event-callout-bubbles">
		<img src="/wp-content/uploads/s4yt-tbd.jpg" class="desktop" />
		<img src="/wp-content/uploads/s4yt-tbd.jpg" class="mobile" />
	</div>
	<div class="event-callout-buttons">
		<a href="/student-registration/"><img src="/wp-content/uploads/form-students.jpg" class="desktop" /></a>
		<a href="/business-registration/"><img src="/wp-content/uploads/help-sponsor-btn" class="desktop" /></a><br />
		<!--a href="/individual-giver/"><img src="/wp-content/uploads/form-individual.jpg" class="desktop" /></a-->
	</div>
</div>

<script>
function showAnswer(_node){
	var answer = _node.nextElementSibling;

	answer.style.display = answer.style.display == 'inline-block' ? 'none' : 'inline-block';
}
</script>

<?php 

get_footer();

?>