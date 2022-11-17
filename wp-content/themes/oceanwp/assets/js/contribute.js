$(document).ready(() => {
	$(".preset-amount").on("click", (e) => {
		const preset = $(e.currentTarget);
		$("#amount").val(preset.data("amount"));
	});

	$("header").on("touchstart", () => {
		$(".header-main").toggleClass("opacity-0");
		$(".header-overlay").toggleClass("opacity-1");
	});
});
