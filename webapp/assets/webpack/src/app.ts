import {bootstrap} from "aurelia-bootstrapper";
import {Aurelia, PLATFORM} from 'aurelia-framework';

declare var PRODUCTION:boolean;

bootstrap((aurelia: Aurelia) => {
    aurelia.use
        .standardConfiguration()
        .plugin(PLATFORM.moduleName('aurelia-validation'))
        .plugin(PLATFORM.moduleName('attributes'))
    ;
    if (PRODUCTION == false) {
        aurelia.use.developmentLogging();
    }
    /* full aurelia app */
    let baseApp = document.querySelector('[vertone-app]') as HTMLElement;
    // @ts-ignore
    aurelia.start().then(() =>
        aurelia.setRoot(PLATFORM.moduleName('App'), baseApp)
    );
    /* full aurelia app */
    /* enhance aurelia app /
    aurelia.start().then(() =>
        aurelia.setRoot(PLATFORM.moduleName('App'), baseApp)
    );
    /* enhance aurelia app */
    if (!Element.prototype.matches) {
        // @ts-ignore
        Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
    }
    if (!Element.prototype.closest) {
        Element.prototype.closest = (s:any) => {
            let el = this;
            // @ts-ignore
            if (!document.documentElement.contains(el)) return null;
            do {
                // @ts-ignore
                if (el.matches(s)) return el;
                // @ts-ignore
                el = el.parentElement || el.parentNode;
                // @ts-ignore
            } while (el !== null && el.nodeType == 1);
            return null;
        };
    }
});
