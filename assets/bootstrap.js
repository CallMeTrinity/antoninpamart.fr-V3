import { startStimulusApp } from "@symfony/stimulus-bridge";
import Flash_controller from "./controllers/flash_controller.js";
import Hamburger_controller from "./controllers/hamburger_controller";

const app = startStimulusApp();
app.register("flash", Flash_controller);
app.register("hamburger", Hamburger_controller);