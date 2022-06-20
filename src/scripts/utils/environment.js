const html = document.documentElement;
const { body } = document;
const isDebug = html.hasAttribute('data-debug');

const scroll = {
	y: 0,
	x: 0,
};

const breakpoints = {
	xs: window.matchMedia('(min-width: 0)'),
	sm: window.matchMedia('(min-width: 754px)'),
	md: window.matchMedia('(min-width: 992px)'),
	lg: window.matchMedia('(min-width: 1200px)'),
	hd: window.matchMedia('(min-width: 2560px)'),
}

const production = 'production' === process.env.NODE_ENV;


export { html, body, isDebug, scroll, breakpoints, production };
