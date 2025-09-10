import { driver } from "driver.js";
import "driver.js/dist/driver.css";

const driver = new Driver();
  overlayColor: 'red'
driver.defineSteps([
    {
        element: '#buscar',popover: {
    title: "Title",
    description: "Description"
  }
}
])