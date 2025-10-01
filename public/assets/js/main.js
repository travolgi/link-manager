// Utils
const getElement = (selector) => document.querySelector(selector);
const getAllElements = (selector) => document.querySelectorAll(selector);
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


// Modals
const newlinkModalBtns = getAllElements('.open-newlink-modal');
const newlinkModal = getElement('#newlink-modal');

const openNewlinkModal = e => {
	const boardId = e.currentTarget.dataset.boardId;
	const select = newlinkModal.querySelector('select[name="board"]');

	if (boardId) {
		select.value = boardId;
		[...select.options].forEach(opt => opt.selected = (opt.value === boardId));
	} else {
		select.value = 'null';
	}

	toggleCssClass(newlinkModal, '!hidden');
	
	const closeNewlinkModalBtn = getElement('#close-newlink-modal');
	closeNewlinkModalBtn.addEventListener('click', () => newlinkModal.classList.add('!hidden'));
}

newlinkModalBtns.forEach(btn => btn.addEventListener('click', openNewlinkModal));