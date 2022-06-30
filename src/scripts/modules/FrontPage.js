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


		if (breakpoints.md.matches) {
			this.$('grid')[0].addEventListener('wheel', () => {
				if (!this.playing) {
					this.playing = true;

					this.$('player')[this.current].play();
				}
			}, false);

			this.$('grid')[0].addEventListener('click', async () => {
				// console.log('click');

				if (!this.playing) {
					await this.$('player')[this.current].play();
					this.playing = true;

				}
			}, false);

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
					// console.log('ended', $player);

					this.playing = false;
					this.current = 0 === index ? 1 : 0;

					$player.style.setProperty('visibility', 'hidden');
					$player.style.setProperty('opacity', '0');
					$player.style.setProperty('z-index', '1');

					$player.currentTime = 0;

					this.$('player')[this.current].style.setProperty('visibility', 'visible');
					this.$('player')[this.current].style.setProperty('opacity', '1');
					this.$('player')[this.current].style.setProperty('z-index', '2');
				});
			});
		}
	}
}

export default FrontPage;
