import './styles/app.css';
import {Application} from "@hotwired/stimulus";

import Search from "./controllers/search_controller.js";

const application = Application.start();
application.register("search", Search);

