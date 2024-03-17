import { startStimulusApp } from '@symfony/stimulus-bundle';

import Flash_controller from "./controllers/flash_controller.js";

const app = startStimulusApp();
app.register("flash", Flash_controller);