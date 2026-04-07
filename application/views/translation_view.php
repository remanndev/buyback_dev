<style>
#google_translate_element > div > div {
	position: relative;
	min-width: 200px;
	height: 30px;
	line-height: 30px;
}
#google_translate_element > div > div > select::-ms-expand {
    display: none;
}
#google_translate_element > div > div:after {
    content: '<>'; /* 목록 펼침 아이콘 */
    font: 17px "Consolas", monospace;
    color: #333;
    transform: rotate(90deg);
    right: 6px;
    top: 3px; /* 18px; */
    padding: 0 0 2px;
    border-bottom: 1px solid #999;
    position: absolute;
    pointer-events: none;
}

#google_translate_element > div > div > select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    display: block;
    width: 100%;
    max-width: 320px;
    height: 30px;
    line-height: 30px;
    float: right;
    margin: 0; /* 5px 0px; */
    padding: 0px 24px;
    font-size: 16px;
    line-height: 1.75;
    color: #333;
    border: 1px solid #cccccc;
    -ms-word-break: normal;
    word-break: normal;
    border-radius: 5px;
}
</style>

<div id="google_translate_element"></div>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
	function googleTranslateElementInit() {
		new google.translate.TranslateElement({pageLanguage: 'ko', includedLanguages : 'ko,en,vi', autoDisplay: false}, 'google_translate_element');
	}
	// 강제 실행
	googleTranslateElementInit();
</script>
