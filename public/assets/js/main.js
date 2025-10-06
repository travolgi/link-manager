// Utils
const getElement = (selector) => document.querySelector(selector);
const getAllElements = (selector) => document.querySelectorAll(selector);
const toggleCssClass = (selector, cssClass) => selector.classList.toggle(cssClass);
const changeAttribute = (target, dataAttribute, val = true) => target.setAttribute(dataAttribute, val);

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


// Header
const header = getElement('header'),
		navToggle = getElement('#nav-toggle'),
		nav = getElement('#navbar'),
		navToggleOpen = getElement('#nav-toggle-open'),
		navToggleClose = getElement('#nav-toggle-close');

const openNavBar = (val = true) => {
	changeAttribute(nav, 'data-visible', val);
	changeAttribute(navToggle, 'aria-expanded', val);
	if (val) {
		[nav, navToggleClose].forEach(ele => ele.classList.remove('hidden'));
		navToggleOpen.classList.add('hidden');
	} else {
		[nav, navToggleClose].forEach(ele => ele.classList.add('hidden'));
		navToggleOpen.classList.remove('hidden');
	}
}

navToggle.addEventListener('click', () => {
	const visible = nav.getAttribute('data-visible');
	if (visible === 'false') {
		openNavBar();
	} else {
		openNavBar(false);
	}
});

document.addEventListener('click', e => {
	if (!header.contains(e.target))  {
		openNavBar(false);
	}
});


// Modals
const newlinkModalBtns = getAllElements('.open-newlink-modal'),
		newlinkModal = getElement('#newlink-modal'),
		newboardModalBtns = getAllElements('.open-board-modal'),
		newboardModal = getElement('#newboard-modal');

const openModal = modal => {
	toggleCssClass(modal, '!hidden');
	const closeModalBtn = modal.querySelector('.close-modal');
	closeModalBtn.addEventListener('click', () => modal.classList.add('!hidden'));
}

const openNewlinkModal = e => {
	const boardId = e.currentTarget.dataset.boardId;
	const select = newlinkModal.querySelector('select[name="board"]');

	if (boardId) {
		select.value = boardId;
		[...select.options].forEach(opt => opt.selected = (opt.value === boardId));
	} else {
		select.value = 'null';
	}

	openModal(newlinkModal);
}

newlinkModalBtns.forEach(btn => btn.addEventListener('click', openNewlinkModal));
newboardModalBtns.forEach(btn => btn.addEventListener('click', () => openModal(newboardModal)));