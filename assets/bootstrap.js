import { startStimulusApp } from "@symfony/stimulus-bridge";
import modal_controller from "./controllers/modal_controller";
import hamburger_controller from "./controllers/hamburger_controller";
import flash_controller from "./controllers/flash_controller.js";
import image_selection_controller from "./controllers/image_selection_controller";

const app = startStimulusApp();
app.register("flash", flash_controller);
app.register("hamburger", hamburger_controller);
app.register("modal", modal_controller);
app.register("image-selection", image_selection_controller);