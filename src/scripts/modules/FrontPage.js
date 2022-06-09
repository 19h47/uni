import { module as M } from '@19h47/modular';
import gsap from 'gsap';
import { breakpoints } from 'utils/environment';


class FrontPage extends M {
	constructor(m) {
		super(m);

		this.currentTime = 0;
		this.current = 0;
		this.playing = false;
	}

	init() {
		this.$('player')[0].load();

		if (breakpoints.md.matches) {
			this.$('grid')[0].addEventListener('wheel', () => {
				if (!this.playing) {
					this.playing = true;

					this.$('player')[this.current].play();
				}
			});

			this.$('grid')[0].addEventListener('click', () => {
				if (!this.playing) {
					this.playing = true;

					this.$('player')[this.current].play();
				}
			});

			this.$('player').forEach(($player, index) => {
				$player.addEventListener('timeupdate', () => {
					gsap.to(this.$('content')[0], {
						duration: 0,
						opacity:
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
						this.$('player')[1].classList.remove('is-hidden');
					} else {
						this.current = 0;
						this.$('player')[0].classList.remove('is-hidden');
					}
				});
			});
		}
	}
}

export default FrontPage;
