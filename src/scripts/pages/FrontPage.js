import { AbstractPage } from 'starting-blocks';
import mediaBreakpointUp from 'utils/mediaBreakpointUp';
import gsap from 'gsap';

/**
 * Front Page
 *
 * @extends {FrontPage}
 * @class
 */
export default class FrontPage extends AbstractPage {
	constructor(container) {
		super(container, 'FrontPage');

		this.currentTime = 0;
		this.current = 0;
		this.playing = false;
	}

	async init() {
		this.players = [...this.rootElement.querySelectorAll('.js-player')];
		this.$content = this.rootElement.querySelector('.js-content');
		this.$grid = this.rootElement.querySelector('.js-grid');

		this.players[0].load();

		await super.init();
	}

	initEvents() {
		if (!mediaBreakpointUp('md')) {
			return;
		}

		super.initEvents();

		this.$grid.addEventListener('wheel', () => {
			if (!this.playing) {
				this.playing = true;

				this.players[this.current].play();
			}
		});

		this.$grid.addEventListener('click', () => {
			if (!this.playing) {
				this.playing = true;

				this.players[this.current].play();
			}
		});

		this.players.forEach(($player, index) => {
			$player.addEventListener('timeupdate', () => {
				gsap.to(this.$content, 0, {
					autoAlpha:
						0 === this.current
							? 1 - $player.currentTime / ($player.duration * 0.5)
							: 0 + $player.currentTime / ($player.duration * 0.5),
				});
			});

			$player.addEventListener('ended', () => {
				this.playing = false;

				$player.classList.add('is-hidden');
				$player.currentTime = 0;

				if (0 === index) {
					this.current = 1;
					this.players[1].classList.remove('is-hidden');
				} else {
					this.current = 0;
					this.players[0].classList.remove('is-hidden');
				}
			});
		});
	}

	onResize() {
		super.onResize();
	}
}
