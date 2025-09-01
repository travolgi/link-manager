// Utils
const getElement = (selector) => document.querySelector(selector);
const toggleCssClass = (selector, cssClass) => selector.classList.toggle(cssClass);

// Light / Dark UI Theme
const uiThemeBtn = getElement('#ui-theme');
const docEle = document.documentElement;

if (uiThemeBtn) {
	const setUiTheme = theme => localStorage.setItem('UiTheme', theme);
	const getUiTheme = () => localStorage.getItem('UiTheme');

	const applyTheme = theme => {
		if (theme === 'dark') {
			docEle.classList.add('dark');
		} else {
			docEle.classList.remove('dark');
		}
	};
	
	const changeUiTheme = () => {
		const isDark = toggleCssClass(docEle, 'dark');
		setUiTheme(isDark ? 'dark' : 'light');
	}

	const initUiTheme = () => {
		const savedUiTheme = getUiTheme();
		if (savedUiTheme) {
			applyTheme(savedUiTheme);
		}
	}
	initUiTheme();

	uiThemeBtn.addEventListener('click', changeUiTheme);
}