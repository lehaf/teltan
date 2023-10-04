/*! nouislider - 14.7.0 - 4/6/2021 */
(function(factory) {
    if (typeof define === "function" && define.amd) {
        define([], factory);
    } else if (typeof exports === "object") {
        module.exports = factory();
    } else {
        window.noUiSlider = factory();
    }
})(function() {
    "use strict";
    var VERSION = "14.7.0";
    //region Helper Methods
    function isValidFormatter(entry) {
        return typeof entry === "object" && typeof entry.to === "function" && typeof entry.from === "function";
    }
    function removeElement(el) {
        el.parentElement.removeChild(el);
    }
    function isSet(value) {
        return value !== null && value !== undefined;
    }
    // Bindable version
    function preventDefault(e) {
        e.preventDefault();
    }
    // Removes duplicates from an array.
    function unique(array) {
        return array.filter(function (a) {
            return !this[a] ? (this[a] = true) : false;
        }, {});
    }
    // Round a value to the closest 'to'.
    function closest(value, to) {
        return Math.round(value / to) * to;
    }
    // Current position of an element relative to the document.
    function offset(elem, orientation) {
        var rect = elem.getBoundingClientRect();
        var doc = elem.ownerDocument;
        var docElem = doc.documentElement;
        var pageOffset = getPageOffset(doc);
        // getBoundingClientRect contains left scroll in Chrome on Android.
        // I haven't found a feature detection that proves this. Worst case
        // scenario on mis-match: the 'tap' feature on horizontal sliders breaks.
        if (/webkit.*Chrome.*Mobile/i.test(navigator.userAgent)) {
            pageOffset.x = 0;
        }
        return orientation ? rect.top + pageOffset.y - docElem.clientTop : rect.left + pageOffset.x - docElem.clientLeft;
    }
    // Checks whether a value is numerical.
    function isNumeric(a) {
        return typeof a === "number" && !isNaN(a) && isFinite(a);
    }
    // Sets a class and removes it after [duration] ms.
    function addClassFor(element, className, duration) {
        if (duration > 0) {
            addClass(element, className);
            setTimeout(function () {
                removeClass(element, className);
            }, duration);
        }
    }
    // Limits a value to 0 - 100
    function limit(a) {
        return Math.max(Math.min(a, 100), 0);
    }
    // Wraps a variable as an array, if it isn't one yet.
    // Note that an input array is returned by reference!
    function asArray(a) {
        return Array.isArray(a) ? a : [a];
    }
    // Counts decimals
    function countDecimals(numStr) {
        numStr = String(numStr);
        var pieces = numStr.split(".");
        return pieces.length > 1 ? pieces[1].length : 0;
    }
    // http://youmightnotneedjquery.com/#add_class
    function addClass(el, className) {
        if (el.classList && !/\s/.test(className)) {
            el.classList.add(className);
        }
        else {
            el.className += " " + className;
        }
    }
    // http://youmightnotneedjquery.com/#remove_class
    function removeClass(el, className) {
        if (el.classList && !/\s/.test(className)) {
            el.classList.remove(className);
        }
        else {
            el.className = el.className.replace(new RegExp("(^|\\b)" + className.split(" ").join("|") + "(\\b|$)", "gi"), " ");
        }
    }
    // https://plainjs.com/javascript/attributes/adding-removing-and-testing-for-classes-9/
    function hasClass(el, className) {
        return el.classList ? el.classList.contains(className) : new RegExp("\\b" + className + "\\b").test(el.className);
    }
    // https://developer.mozilla.org/en-US/docs/Web/API/Window/scrollY#Notes
    function getPageOffset(doc) {
        var supportPageOffset = window.pageXOffset !== undefined;
        var isCSS1Compat = (doc.compatMode || "") === "CSS1Compat";
        var x = supportPageOffset
            ? window.pageXOffset
            : isCSS1Compat
                ? doc.documentElement.scrollLeft
                : doc.body.scrollLeft;
        var y = supportPageOffset ? window.pageYOffset : isCSS1Compat ? doc.documentElement.scrollTop : doc.body.scrollTop;
        return {
            x: x,
            y: y
        };
    }
    // we provide a function to compute constants instead
    // of accessing window.* as soon as the module needs it
    // so that we do not compute anything if not needed
    function getActions() {
        // Determine the events to bind. IE11 implements pointerEvents without
        // a prefix, which breaks compatibility with the IE10 implementation.
        return window.navigator.pointerEnabled
            ? {
                start: "pointerdown",
                move: "pointermove",
                end: "pointerup"
            }
            : window.navigator.msPointerEnabled
                ? {
                    start: "MSPointerDown",
                    move: "MSPointerMove",
                    end: "MSPointerUp"
                }
                : {
                    start: "mousedown touchstart",
                    move: "mousemove touchmove",
                    end: "mouseup touchend"
                };
    }
    // https://github.com/WICG/EventListenerOptions/blob/gh-pages/explainer.md
    // Issue #785
    function getSupportsPassive() {
        var supportsPassive = false;
        /* eslint-disable */
        try {
            var opts = Object.defineProperty({}, "passive", {
                get: function () {
                    supportsPassive = true;
                }
            });
            window.addEventListener("test", null, opts);
        }
        catch (e) { }
        /* eslint-enable */
        return supportsPassive;
    }
    function getSupportsTouchActionNone() {
        return window.CSS && CSS.supports && CSS.supports("touch-action", "none");
    }
    //endregion
    //region Range Calculation
    // Determine the size of a sub-range in relation to a full range.
    function subRangeRatio(pa, pb) {
        return 100 / (pb - pa);
    }
    // (percentage) How many percent is this value of this range?
    function fromPercentage(range, value, startRange) {
        return (value * 100) / (range[startRange + 1] - range[startRange]);
    }
    // (percentage) Where is this value on this range?
    function toPercentage(range, value) {
        return fromPercentage(range, range[0] < 0 ? value + Math.abs(range[0]) : value - range[0], 0);
    }
    // (value) How much is this percentage on this range?
    function isPercentage(range, value) {
        return (value * (range[1] - range[0])) / 100 + range[0];
    }
    function getJ(value, arr) {
        var j = 1;
        while (value >= arr[j]) {
            j += 1;
        }
        return j;
    }
    // (percentage) Input a value, find where, on a scale of 0-100, it applies.
    function toStepping(xVal, xPct, value) {
        if (value >= xVal.slice(-1)[0]) {
            return 100;
        }
        var j = getJ(value, xVal);
        var va = xVal[j - 1];
        var vb = xVal[j];
        var pa = xPct[j - 1];
        var pb = xPct[j];
        return pa + toPercentage([va, vb], value) / subRangeRatio(pa, pb);
    }
    // (value) Input a percentage, find where it is on the specified range.
    function fromStepping(xVal, xPct, value) {
        // There is no range group that fits 100
        if (value >= 100) {
            return xVal.slice(-1)[0];
        }
        var j = getJ(value, xPct);
        var va = xVal[j - 1];
        var vb = xVal[j];
        var pa = xPct[j - 1];
        var pb = xPct[j];
        return isPercentage([va, vb], (value - pa) * subRangeRatio(pa, pb));
    }
    // (percentage) Get the step that applies at a certain value.
    function getStep(xPct, xSteps, snap, value) {
        if (value === 100) {
            return value;
        }
        var j = getJ(value, xPct);
        var a = xPct[j - 1];
        var b = xPct[j];
        // If 'snap' is set, steps are used as fixed points on the slider.
        if (snap) {
            // Find the closest position, a or b.
            if (value - a > (b - a) / 2) {
                return b;
            }
            return a;
        }
        if (!xSteps[j - 1]) {
            return value;
        }
        return xPct[j - 1] + closest(value - xPct[j - 1], xSteps[j - 1]);
    }
    function handleEntryPoint(index, value, that) {
        var percentage;
        // Wrap numerical input in an array.
        if (typeof value === "number") {
            value = [value];
        }
        // Reject any invalid input, by testing whether value is an array.
        if (!Array.isArray(value)) {
            throw new Error("noUiSlider (" + VERSION + "): 'range' contains invalid value.");
        }
        // Covert min/max syntax to 0 and 100.
        if (index === "min") {
            percentage = 0;
        }
        else if (index === "max") {
            percentage = 100;
        }
        else {
            percentage = parseFloat(index);
        }
        // Check for correct input.
        if (!isNumeric(percentage) || !isNumeric(value[0])) {
            throw new Error("noUiSlider (" + VERSION + "): 'range' value isn't numeric.");
        }
        // Store values.
        that.xPct.push(percentage);
        that.xVal.push(value[0]);
        // NaN will evaluate to false too, but to keep
        // logging clear, set step explicitly. Make sure
        // not to override the 'step' setting with false.
        if (!percentage) {
            if (!isNaN(value[1])) {
                that.xSteps[0] = value[1];
            }
        }
        else {
            that.xSteps.push(isNaN(value[1]) ? false : value[1]);
        }
        that.xHighestCompleteStep.push(0);
    }
    function handleStepPoint(i, n, that) {
        // Ignore 'false' stepping.
        if (!n) {
            return;
        }
        // Step over zero-length ranges (#948);
        if (that.xVal[i] === that.xVal[i + 1]) {
            that.xSteps[i] = that.xHighestCompleteStep[i] = that.xVal[i];
            return;
        }
        // Factor to range ratio
        that.xSteps[i] =
            fromPercentage([that.xVal[i], that.xVal[i + 1]], n, 0) / subRangeRatio(that.xPct[i], that.xPct[i + 1]);
        var totalSteps = (that.xVal[i + 1] - that.xVal[i]) / that.xNumSteps[i];
        var highestStep = Math.ceil(Number(totalSteps.toFixed(3)) - 1);
        var step = that.xVal[i] + that.xNumSteps[i] * highestStep;
        that.xHighestCompleteStep[i] = step;
    }
    //endregion
    //region Spectrum
    function Spectrum(entry, snap, singleStep) {
        this.xPct = [];
        this.xVal = [];
        this.xSteps = [singleStep || false];
        this.xNumSteps = [false];
        this.xHighestCompleteStep = [];
        this.snap = snap;
        var index;
        var ordered = []; // [0, 'min'], [1, '50%'], [2, 'max']
        // Map the object keys to an array.
        for (index in entry) {
            if (entry.hasOwnProperty(index)) {
                ordered.push([entry[index], index]);
            }
        }
        // Sort all entries by value (numeric sort).
        if (ordered.length && typeof ordered[0][0] === "object") {
            ordered.sort(function (a, b) {
                return a[0][0] - b[0][0];
            });
        }
        else {
            ordered.sort(function (a, b) {
                return a[0] - b[0];
            });
        }
        // Convert all entries to subranges.
        for (index = 0; index < ordered.length; index++) {
            handleEntryPoint(ordered[index][1], ordered[index][0], this);
        }
        // Store the actual step values.
        // xSteps is sorted in the same order as xPct and xVal.
        this.xNumSteps = this.xSteps.slice(0);
        // Convert all numeric steps to the percentage of the subrange they represent.
        for (index = 0; index < this.xNumSteps.length; index++) {
            handleStepPoint(index, this.xNumSteps[index], this);
        }
    }
    Spectrum.prototype.getDistance = function (value) {
        var index;
        var distances = [];
        for (index = 0; index < this.xNumSteps.length - 1; index++) {
            // last "range" can't contain step size as it is purely an endpoint.
            var step = this.xNumSteps[index];
            if (step && (value / step) % 1 !== 0) {
                throw new Error("noUiSlider (" +
                    VERSION +
                    "): 'limit', 'margin' and 'padding' of " +
                    this.xPct[index] +
                    "% range must be divisible by step.");
            }
            // Calculate percentual distance in current range of limit, margin or padding
            distances[index] = fromPercentage(this.xVal, value, index);
        }
        return distances;
    };
    // Calculate the percentual distance over the whole scale of ranges.
    // direction: 0 = backwards / 1 = forwards
    Spectrum.prototype.getAbsoluteDistance = function (value, distances, direction) {
        var xPct_index = 0;
        // Calculate range where to start calculation
        if (value < this.xPct[this.xPct.length - 1]) {
            while (value > this.xPct[xPct_index + 1]) {
                xPct_index++;
            }
        }
        else if (value === this.xPct[this.xPct.length - 1]) {
            xPct_index = this.xPct.length - 2;
        }
        // If looking backwards and the value is exactly at a range separator then look one range further
        if (!direction && value === this.xPct[xPct_index + 1]) {
            xPct_index++;
        }
        var start_factor;
        var rest_factor = 1;
        var rest_rel_distance = distances[xPct_index];
        var range_pct = 0;
        var rel_range_distance = 0;
        var abs_distance_counter = 0;
        var range_counter = 0;
        // Calculate what part of the start range the value is
        if (direction) {
            start_factor = (value - this.xPct[xPct_index]) / (this.xPct[xPct_index + 1] - this.xPct[xPct_index]);
        }
        else {
            start_factor = (this.xPct[xPct_index + 1] - value) / (this.xPct[xPct_index + 1] - this.xPct[xPct_index]);
        }
        // Do until the complete distance across ranges is calculated
        while (rest_rel_distance > 0) {
            // Calculate the percentage of total range
            range_pct = this.xPct[xPct_index + 1 + range_counter] - this.xPct[xPct_index + range_counter];
            // Detect if the margin, padding or limit is larger then the current range and calculate
            if (distances[xPct_index + range_counter] * rest_factor + 100 - start_factor * 100 > 100) {
                // If larger then take the percentual distance of the whole range
                rel_range_distance = range_pct * start_factor;
                // Rest factor of relative percentual distance still to be calculated
                rest_factor = (rest_rel_distance - 100 * start_factor) / distances[xPct_index + range_counter];
                // Set start factor to 1 as for next range it does not apply.
                start_factor = 1;
            }
            else {
                // If smaller or equal then take the percentual distance of the calculate percentual part of that range
                rel_range_distance = ((distances[xPct_index + range_counter] * range_pct) / 100) * rest_factor;
                // No rest left as the rest fits in current range
                rest_factor = 0;
            }
            if (direction) {
                abs_distance_counter = abs_distance_counter - rel_range_distance;
                // Limit range to first range when distance becomes outside of minimum range
                if (this.xPct.length + range_counter >= 1) {
                    range_counter--;
                }
            }
            else {
                abs_distance_counter = abs_distance_counter + rel_range_distance;
                // Limit range to last range when distance becomes outside of maximum range
                if (this.xPct.length - range_counter >= 1) {
                    range_counter++;
                }
            }
            // Rest of relative percentual distance still to be calculated
            rest_rel_distance = distances[xPct_index + range_counter] * rest_factor;
        }
        return value + abs_distance_counter;
    };
    Spectrum.prototype.toStepping = function (value) {
        value = toStepping(this.xVal, this.xPct, value);
        return value;
    };
    Spectrum.prototype.fromStepping = function (value) {
        return fromStepping(this.xVal, this.xPct, value);
    };
    Spectrum.prototype.getStep = function (value) {
        value = getStep(this.xPct, this.xSteps, this.snap, value);
        return value;
    };
    Spectrum.prototype.getDefaultStep = function (value, isDown, size) {
        var j = getJ(value, this.xPct);
        // When at the top or stepping down, look at the previous sub-range
        if (value === 100 || (isDown && value === this.xPct[j - 1])) {
            j = Math.max(j - 1, 1);
        }
        return (this.xVal[j] - this.xVal[j - 1]) / size;
    };
    Spectrum.prototype.getNearbySteps = function (value) {
        var j = getJ(value, this.xPct);
        return {
            stepBefore: {
                startValue: this.xVal[j - 2],
                step: this.xNumSteps[j - 2],
                highestStep: this.xHighestCompleteStep[j - 2]
            },
            thisStep: {
                startValue: this.xVal[j - 1],
                step: this.xNumSteps[j - 1],
                highestStep: this.xHighestCompleteStep[j - 1]
            },
            stepAfter: {
                startValue: this.xVal[j],
                step: this.xNumSteps[j],
                highestStep: this.xHighestCompleteStep[j]
            }
        };
    };
    Spectrum.prototype.countStepDecimals = function () {
        var stepDecimals = this.xNumSteps.map(countDecimals);
        return Math.max.apply(null, stepDecimals);
    };
    // Outside testing
    Spectrum.prototype.convert = function (value) {
        return this.getStep(this.toStepping(value));
    };
    //endregion
    //region Options
    /*	Every input option is tested and parsed. This'll prevent
        endless validation in internal methods. These tests are
        structured with an item for every option available. An
        option can be marked as required by setting the 'r' flag.
        The testing function is provided with three arguments:
            - The provided value for the option;
            - A reference to the options object;
            - The name for the option;

        The testing function returns false when an error is detected,
        or true when everything is OK. It can also modify the option
        object, to make sure all values can be correctly looped elsewhere. */
    //region Defaults
    var defaultFormatter = {
        to: function (value) {
            return value !== undefined && value.toFixed(2);
        },
        from: Number
    };
    var cssClasses = {
        target: "target",
        base: "base",
        origin: "origin",
        handle: "handle",
        handleLower: "handle-lower",
        handleUpper: "handle-upper",
        touchArea: "touch-area",
        horizontal: "horizontal",
        vertical: "vertical",
        background: "background",
        connect: "connect",
        connects: "connects",
        ltr: "ltr",
        rtl: "rtl",
        textDirectionLtr: "txt-dir-ltr",
        textDirectionRtl: "txt-dir-rtl",
        draggable: "draggable",
        drag: "state-drag",
        tap: "state-tap",
        active: "active",
        tooltip: "tooltip",
        pips: "pips",
        pipsHorizontal: "pips-horizontal",
        pipsVertical: "pips-vertical",
        marker: "marker",
        markerHorizontal: "marker-horizontal",
        markerVertical: "marker-vertical",
        markerNormal: "marker-normal",
        markerLarge: "marker-large",
        markerSub: "marker-sub",
        value: "value",
        valueHorizontal: "value-horizontal",
        valueVertical: "value-vertical",
        valueNormal: "value-normal",
        valueLarge: "value-large",
        valueSub: "value-sub"
    };
    // Namespaces of internal event listeners
    var INTERNAL_EVENT_NS = {
        tooltips: ".__tooltips",
        aria: ".__aria"
    };
    //endregion
    function validateFormat(entry) {
        // Any object with a to and from method is supported.
        if (isValidFormatter(entry)) {
            return true;
        }
        throw new Error("noUiSlider (" + VERSION + "): 'format' requires 'to' and 'from' methods.");
    }
    function testStep(parsed, entry) {
        if (!isNumeric(entry)) {
            throw new Error("noUiSlider (" + VERSION + "): 'step' is not numeric.");
        }
        // The step option can still be used to set stepping
        // for linear sliders. Overwritten if set in 'range'.
        parsed.singleStep = entry;
    }
    function testKeyboardPageMultiplier(parsed, entry) {
        if (!isNumeric(entry)) {
            throw new Error("noUiSlider (" + VERSION + "): 'keyboardPageMultiplier' is not numeric.");
        }
        parsed.keyboardPageMultiplier = entry;
    }
    function testKeyboardDefaultStep(parsed, entry) {
        if (!isNumeric(entry)) {
            throw new Error("noUiSlider (" + VERSION + "): 'keyboardDefaultStep' is not numeric.");
        }
        parsed.keyboardDefaultStep = entry;
    }
    function testRange(parsed, entry) {
        // Filter incorrect input.
        if (typeof entry !== "object" || Array.isArray(entry)) {
            throw new Error("noUiSlider (" + VERSION + "): 'range' is not an object.");
        }
        // Catch missing start or end.
        if (entry.min === undefined || entry.max === undefined) {
            throw new Error("noUiSlider (" + VERSION + "): Missing 'min' or 'max' in 'range'.");
        }
        // Catch equal start or end.
        if (entry.min === entry.max) {
            throw new Error("noUiSlider (" + VERSION + "): 'range' 'min' and 'max' cannot be equal.");
        }
        parsed.spectrum = new Spectrum(entry, parsed.snap, parsed.singleStep);
    }
    function testStart(parsed, entry) {
        entry = asArray(entry);
        // Validate input. Values aren't tested, as the public .val method
        // will always provide a valid location.
        if (!Array.isArray(entry) || !entry.length) {
            throw new Error("noUiSlider (" + VERSION + "): 'start' option is incorrect.");
        }
        // Store the number of handles.
        parsed.handles = entry.length;
        // When the slider is initialized, the .val method will
        // be called with the start options.
        parsed.start = entry;
    }
    function testSnap(parsed, entry) {
        // Enforce 100% stepping within subranges.
        parsed.snap = entry;
        if (typeof entry !== "boolean") {
            throw new Error("noUiSlider (" + VERSION + "): 'snap' option must be a boolean.");
        }
    }
    function testAnimate(parsed, entry) {
        // Enforce 100% stepping within subranges.
        parsed.animate = entry;
        if (typeof entry !== "boolean") {
            throw new Error("noUiSlider (" + VERSION + "): 'animate' option must be a boolean.");
        }
    }
    function testAnimationDuration(parsed, entry) {
        parsed.animationDuration = entry;
        if (typeof entry !== "number") {
            throw new Error("noUiSlider (" + VERSION + "): 'animationDuration' option must be a number.");
        }
    }
    function testConnect(parsed, entry) {
        var connect = [false];
        var i;
        // Map legacy options
        if (entry === "lower") {
            entry = [true, false];
        }
        else if (entry === "upper") {
            entry = [false, true];
        }
        // Handle boolean options
        if (entry === true || entry === false) {
            for (i = 1; i < parsed.handles; i++) {
                connect.push(entry);
            }
            connect.push(false);
        }
        // Reject invalid input
        else if (!Array.isArray(entry) || !entry.length || entry.length !== parsed.handles + 1) {
            throw new Error("noUiSlider (" + VERSION + "): 'connect' option doesn't match handle count.");
        }
        else {
            connect = entry;
        }
        parsed.connect = connect;
    }
    function testOrientation(parsed, entry) {
        // Set orientation to an a numerical value for easy
        // array selection.
        switch (entry) {
            case "horizontal":
                parsed.ort = 0;
                break;
            case "vertical":
                parsed.ort = 1;
                break;
            default:
                throw new Error("noUiSlider (" + VERSION + "): 'orientation' option is invalid.");
        }
    }
    function testMargin(parsed, entry) {
        if (!isNumeric(entry)) {
            throw new Error("noUiSlider (" + VERSION + "): 'margin' option must be numeric.");
        }
        // Issue #582
        if (entry === 0) {
            return;
        }
        parsed.margin = parsed.spectrum.getDistance(entry);
    }
    function testLimit(parsed, entry) {
        if (!isNumeric(entry)) {
            throw new Error("noUiSlider (" + VERSION + "): 'limit' option must be numeric.");
        }
        parsed.limit = parsed.spectrum.getDistance(entry);
        if (!parsed.limit || parsed.handles < 2) {
            throw new Error("noUiSlider (" + VERSION + "): 'limit' option is only supported on linear sliders with 2 or more handles.");
        }
    }
    function testPadding(parsed, entry) {
        var index;
        if (!isNumeric(entry) && !Array.isArray(entry)) {
            throw new Error("noUiSlider (" + VERSION + "): 'padding' option must be numeric or array of exactly 2 numbers.");
        }
        if (Array.isArray(entry) && !(entry.length === 2 || isNumeric(entry[0]) || isNumeric(entry[1]))) {
            throw new Error("noUiSlider (" + VERSION + "): 'padding' option must be numeric or array of exactly 2 numbers.");
        }
        if (entry === 0) {
            return;
        }
        if (!Array.isArray(entry)) {
            entry = [entry, entry];
        }
        // 'getDistance' returns false for invalid values.
        parsed.padding = [parsed.spectrum.getDistance(entry[0]), parsed.spectrum.getDistance(entry[1])];
        for (index = 0; index < parsed.spectrum.xNumSteps.length - 1; index++) {
            // last "range" can't contain step size as it is purely an endpoint.
            if (parsed.padding[0][index] < 0 || parsed.padding[1][index] < 0) {
                throw new Error("noUiSlider (" + VERSION + "): 'padding' option must be a positive number(s).");
            }
        }
        var totalPadding = entry[0] + entry[1];
        var firstValue = parsed.spectrum.xVal[0];
        var lastValue = parsed.spectrum.xVal[parsed.spectrum.xVal.length - 1];
        if (totalPadding / (lastValue - firstValue) > 1) {
            throw new Error("noUiSlider (" + VERSION + "): 'padding' option must not exceed 100% of the range.");
        }
    }
    function testDirection(parsed, entry) {
        // Set direction as a numerical value for easy parsing.
        // Invert connection for RTL sliders, so that the proper
        // handles get the connect/background classes.
        switch (entry) {
            case "ltr":
                parsed.dir = 0;
                break;
            case "rtl":
                parsed.dir = 1;
                break;
            default:
                throw new Error("noUiSlider (" + VERSION + "): 'direction' option was not recognized.");
        }
    }
    function testBehaviour(parsed, entry) {
        // Make sure the input is a string.
        if (typeof entry !== "string") {
            throw new Error("noUiSlider (" + VERSION + "): 'behaviour' must be a string containing options.");
        }
        // Check if the string contains any keywords.
        // None are required.
        var tap = entry.indexOf("tap") >= 0;
        var drag = entry.indexOf("drag") >= 0;
        var fixed = entry.indexOf("fixed") >= 0;
        var snap = entry.indexOf("snap") >= 0;
        var hover = entry.indexOf("hover") >= 0;
        var unconstrained = entry.indexOf("unconstrained") >= 0;
        if (fixed) {
            if (parsed.handles !== 2) {
                throw new Error("noUiSlider (" + VERSION + "): 'fixed' behaviour must be used with 2 handles");
            }
            // Use margin to enforce fixed state
            testMargin(parsed, parsed.start[1] - parsed.start[0]);
        }
        if (unconstrained && (parsed.margin || parsed.limit)) {
            throw new Error("noUiSlider (" + VERSION + "): 'unconstrained' behaviour cannot be used with margin or limit");
        }
        parsed.events = {
            tap: tap || snap,
            drag: drag,
            fixed: fixed,
            snap: snap,
            hover: hover,
            unconstrained: unconstrained
        };
    }
    function testTooltips(parsed, entry) {
        if (entry === false) {
            return;
        }
        if (entry === true) {
            parsed.tooltips = [];
            for (var i = 0; i < parsed.handles; i++) {
                parsed.tooltips.push(true);
            }
        }
        else {
            parsed.tooltips = asArray(entry);
            if (parsed.tooltips.length !== parsed.handles) {
                throw new Error("noUiSlider (" + VERSION + "): must pass a formatter for all handles.");
            }
            parsed.tooltips.forEach(function (formatter) {
                if (typeof formatter !== "boolean" &&
                    (typeof formatter !== "object" || typeof formatter.to !== "function")) {
                    throw new Error("noUiSlider (" + VERSION + "): 'tooltips' must be passed a formatter or 'false'.");
                }
            });
        }
    }
    function testAriaFormat(parsed, entry) {
        parsed.ariaFormat = entry;
        validateFormat(entry);
    }
    function testFormat(parsed, entry) {
        parsed.format = entry;
        validateFormat(entry);
    }
    function testKeyboardSupport(parsed, entry) {
        parsed.keyboardSupport = entry;
        if (typeof entry !== "boolean") {
            throw new Error("noUiSlider (" + VERSION + "): 'keyboardSupport' option must be a boolean.");
        }
    }
    function testDocumentElement(parsed, entry) {
        // This is an advanced option. Passed values are used without validation.
        parsed.documentElement = entry;
    }
    function testCssPrefix(parsed, entry) {
        if (typeof entry !== "string" && entry !== false) {
            throw new Error("noUiSlider (" + VERSION + "): 'cssPrefix' must be a string or `false`.");
        }
        parsed.cssPrefix = entry;
    }
    function testCssClasses(parsed, entry) {
        if (typeof entry !== "object") {
            throw new Error("noUiSlider (" + VERSION + "): 'cssClasses' must be an object.");
        }
        if (typeof parsed.cssPrefix === "string") {
            parsed.cssClasses = {};
            for (var key in entry) {
                if (!entry.hasOwnProperty(key)) {
                    continue;
                }
                parsed.cssClasses[key] = parsed.cssPrefix + entry[key];
            }
        }
        else {
            parsed.cssClasses = entry;
        }
    }
    // Test all developer settings and parse to assumption-safe values.
    function testOptions(options) {
        // To prove a fix for #537, freeze options here.
        // If the object is modified, an error will be thrown.
        // Object.freeze(options);
        var parsed = {
            margin: 0,
            limit: 0,
            padding: 0,
            animate: true,
            animationDuration: 300,
            ariaFormat: defaultFormatter,
            format: defaultFormatter
        };
        // Tests are executed in the order they are presented here.
        var tests = {
            step: { r: false, t: testStep },
            keyboardPageMultiplier: { r: false, t: testKeyboardPageMultiplier },
            keyboardDefaultStep: { r: false, t: testKeyboardDefaultStep },
            start: { r: true, t: testStart },
            connect: { r: true, t: testConnect },
            direction: { r: true, t: testDirection },
            snap: { r: false, t: testSnap },
            animate: { r: false, t: testAnimate },
            animationDuration: { r: false, t: testAnimationDuration },
            range: { r: true, t: testRange },
            orientation: { r: false, t: testOrientation },
            margin: { r: false, t: testMargin },
            limit: { r: false, t: testLimit },
            padding: { r: false, t: testPadding },
            behaviour: { r: true, t: testBehaviour },
            ariaFormat: { r: false, t: testAriaFormat },
            format: { r: false, t: testFormat },
            tooltips: { r: false, t: testTooltips },
            keyboardSupport: { r: true, t: testKeyboardSupport },
            documentElement: { r: false, t: testDocumentElement },
            cssPrefix: { r: true, t: testCssPrefix },
            cssClasses: { r: true, t: testCssClasses }
        };
        var defaults = {
            connect: false,
            direction: "ltr",
            behaviour: "tap",
            orientation: "horizontal",
            keyboardSupport: true,
            cssPrefix: "noUi-",
            cssClasses: cssClasses,
            keyboardPageMultiplier: 5,
            keyboardDefaultStep: 10
        };
        // AriaFormat defaults to regular format, if any.
        if (options.format && !options.ariaFormat) {
            options.ariaFormat = options.format;
        }
        // Run all options through a testing mechanism to ensure correct
        // input. It should be noted that options might get modified to
        // be handled properly. E.g. wrapping integers in arrays.
        Object.keys(tests).forEach(function (name) {
            // If the option isn't set, but it is required, throw an error.
            if (!isSet(options[name]) && defaults[name] === undefined) {
                if (tests[name].r) {
                    throw new Error("noUiSlider (" + VERSION + "): '" + name + "' is required.");
                }
                return true;
            }
            tests[name].t(parsed, !isSet(options[name]) ? defaults[name] : options[name]);
        });
        // Forward pips options
        parsed.pips = options.pips;
        // All recent browsers accept unprefixed transform.
        // We need -ms- for IE9 and -webkit- for older Android;
        // Assume use of -webkit- if unprefixed and -ms- are not supported.
        // https://caniuse.com/#feat=transforms2d
        var d = document.createElement("div");
        var msPrefix = d.style.msTransform !== undefined;
        var noPrefix = d.style.transform !== undefined;
        parsed.transformRule = noPrefix ? "transform" : msPrefix ? "msTransform" : "webkitTransform";
        // Pips don't move, so we can place them using left/top.
        var styles = [["left", "top"], ["right", "bottom"]];
        parsed.style = styles[parsed.dir][parsed.ort];
        return parsed;
    }
    //endregion
    function scope(target, options, originalOptions) {
        var actions = getActions();
        var supportsTouchActionNone = getSupportsTouchActionNone();
        var supportsPassive = supportsTouchActionNone && getSupportsPassive();
        // All variables local to 'scope' are prefixed with 'scope_'
        // Slider DOM Nodes
        var scope_Target = target;
        var scope_Base;
        var scope_Handles;
        var scope_Connects;
        var scope_Pips;
        var scope_Tooltips;
        // Slider state values
        var scope_Spectrum = options.spectrum;
        var scope_Values = [];
        var scope_Locations = [];
        var scope_HandleNumbers = [];
        var scope_ActiveHandlesCount = 0;
        var scope_Events = {};
        // Exposed API
        var scope_Self;
        // Document Nodes
        var scope_Document = target.ownerDocument;
        var scope_DocumentElement = options.documentElement || scope_Document.documentElement;
        var scope_Body = scope_Document.body;
        // Pips constants
        var PIPS_NONE = -1;
        var PIPS_NO_VALUE = 0;
        var PIPS_LARGE_VALUE = 1;
        var PIPS_SMALL_VALUE = 2;
        // For horizontal sliders in standard ltr documents,
        // make .noUi-origin overflow to the left so the document doesn't scroll.
        var scope_DirOffset = scope_Document.dir === "rtl" || options.ort === 1 ? 0 : 100;
        // Creates a node, adds it to target, returns the new node.
        function addNodeTo(addTarget, className) {
            var div = scope_Document.createElement("div");
            if (className) {
                addClass(div, className);
            }
            addTarget.appendChild(div);
            return div;
        }
        // Append a origin to the base
        function addOrigin(base, handleNumber) {
            var origin = addNodeTo(base, options.cssClasses.origin);
            var handle = addNodeTo(origin, options.cssClasses.handle);
            addNodeTo(handle, options.cssClasses.touchArea);
            handle.setAttribute("data-handle", handleNumber);
            if (options.keyboardSupport) {
                // https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/tabindex
                // 0 = focusable and reachable
                handle.setAttribute("tabindex", "0");
                handle.addEventListener("keydown", function (event) {
                    return eventKeydown(event, handleNumber);
                });
            }
            handle.setAttribute("role", "slider");
            handle.setAttribute("aria-orientation", options.ort ? "vertical" : "horizontal");
            if (handleNumber === 0) {
                addClass(handle, options.cssClasses.handleLower);
            }
            else if (handleNumber === options.handles - 1) {
                addClass(handle, options.cssClasses.handleUpper);
            }
            return origin;
        }
        // Insert nodes for connect elements
        function addConnect(base, add) {
            if (!add) {
                return false;
            }
            return addNodeTo(base, options.cssClasses.connect);
        }
        // Add handles to the slider base.
        function addElements(connectOptions, base) {
            var connectBase = addNodeTo(base, options.cssClasses.connects);
            scope_Handles = [];
            scope_Connects = [];
            scope_Connects.push(addConnect(connectBase, connectOptions[0]));
            // [::::O====O====O====]
            // connectOptions = [0, 1, 1, 1]
            for (var i = 0; i < options.handles; i++) {
                // Keep a list of all added handles.
                scope_Handles.push(addOrigin(base, i));
                scope_HandleNumbers[i] = i;
                scope_Connects.push(addConnect(connectBase, connectOptions[i + 1]));
            }
        }
        // Initialize a single slider.
        function addSlider(addTarget) {
            // Apply classes and data to the target.
            addClass(addTarget, options.cssClasses.target);
            if (options.dir === 0) {
                addClass(addTarget, options.cssClasses.ltr);
            }
            else {
                addClass(addTarget, options.cssClasses.rtl);
            }
            if (options.ort === 0) {
                addClass(addTarget, options.cssClasses.horizontal);
            }
            else {
                addClass(addTarget, options.cssClasses.vertical);
            }
            var textDirection = getComputedStyle(addTarget).direction;
            if (textDirection === "rtl") {
                addClass(addTarget, options.cssClasses.textDirectionRtl);
            }
            else {
                addClass(addTarget, options.cssClasses.textDirectionLtr);
            }
            return addNodeTo(addTarget, options.cssClasses.base);
        }
        function addTooltip(handle, handleNumber) {
            if (!options.tooltips[handleNumber]) {
                return false;
            }
            return addNodeTo(handle.firstChild, options.cssClasses.tooltip);
        }
        function isSliderDisabled() {
            return scope_Target.hasAttribute("disabled");
        }
        // Disable the slider dragging if any handle is disabled
        function isHandleDisabled(handleNumber) {
            var handleOrigin = scope_Handles[handleNumber];
            return handleOrigin.hasAttribute("disabled");
        }
        function removeTooltips() {
            if (scope_Tooltips) {
                removeEvent("update" + INTERNAL_EVENT_NS.tooltips);
                scope_Tooltips.forEach(function (tooltip) {
                    if (tooltip) {
                        removeElement(tooltip);
                    }
                });
                scope_Tooltips = null;
            }
        }
        // The tooltips option is a shorthand for using the 'update' event.
        function tooltips() {
            removeTooltips();
            // Tooltips are added with options.tooltips in original order.
            scope_Tooltips = scope_Handles.map(addTooltip);
            bindEvent("update" + INTERNAL_EVENT_NS.tooltips, function (values, handleNumber, unencoded) {
                if (!scope_Tooltips[handleNumber]) {
                    return;
                }
                var formattedValue = values[handleNumber];
                if (options.tooltips[handleNumber] !== true) {
                    formattedValue = options.tooltips[handleNumber].to(unencoded[handleNumber]);
                }
                scope_Tooltips[handleNumber].innerHTML = formattedValue;
            });
        }
        function aria() {
            removeEvent("update" + INTERNAL_EVENT_NS.aria);
            bindEvent("update" + INTERNAL_EVENT_NS.aria, function (values, handleNumber, unencoded, tap, positions) {
                // Update Aria Values for all handles, as a change in one changes min and max values for the next.
                scope_HandleNumbers.forEach(function (index) {
                    var handle = scope_Handles[index];
                    var min = checkHandlePosition(scope_Locations, index, 0, true, true, true);
                    var max = checkHandlePosition(scope_Locations, index, 100, true, true, true);
                    var now = positions[index];
                    // Formatted value for display
                    var text = options.ariaFormat.to(unencoded[index]);
                    // Map to slider range values
                    min = scope_Spectrum.fromStepping(min).toFixed(1);
                    max = scope_Spectrum.fromStepping(max).toFixed(1);
                    now = scope_Spectrum.fromStepping(now).toFixed(1);
                    handle.children[0].setAttribute("aria-valuemin", min);
                    handle.children[0].setAttribute("aria-valuemax", max);
                    handle.children[0].setAttribute("aria-valuenow", now);
                    handle.children[0].setAttribute("aria-valuetext", text);
                });
            });
        }
        function getGroup(mode, values, stepped) {
            // Use the range.
            if (mode === "range" || mode === "steps") {
                return scope_Spectrum.xVal;
            }
            if (mode === "count") {
                if (values < 2) {
                    throw new Error("noUiSlider (" + VERSION + "): 'values' (>= 2) required for mode 'count'.");
                }
                // Divide 0 - 100 in 'count' parts.
                var interval = values - 1;
                var spread = 100 / interval;
                values = [];
                // List these parts and have them handled as 'positions'.
                while (interval--) {
                    values[interval] = interval * spread;
                }
                values.push(100);
                mode = "positions";
            }
            if (mode === "positions") {
                // Map all percentages to on-range values.
                return values.map(function (value) {
                    return scope_Spectrum.fromStepping(stepped ? scope_Spectrum.getStep(value) : value);
                });
            }
            if (mode === "values") {
                // If the value must be stepped, it needs to be converted to a percentage first.
                if (stepped) {
                    return values.map(function (value) {
                        // Convert to percentage, apply step, return to value.
                        return scope_Spectrum.fromStepping(scope_Spectrum.getStep(scope_Spectrum.toStepping(value)));
                    });
                }
                // Otherwise, we can simply use the values.
                return values;
            }
        }
        function generateSpread(density, mode, group) {
            function safeIncrement(value, increment) {
                // Avoid floating point variance by dropping the smallest decimal places.
                return (value + increment).toFixed(7) / 1;
            }
            var indexes = {};
            var firstInRange = scope_Spectrum.xVal[0];
            var lastInRange = scope_Spectrum.xVal[scope_Spectrum.xVal.length - 1];
            var ignoreFirst = false;
            var ignoreLast = false;
            var prevPct = 0;
            // Create a copy of the group, sort it and filter away all duplicates.
            group = unique(group.slice().sort(function (a, b) {
                return a - b;
            }));
            // Make sure the range starts with the first element.
            if (group[0] !== firstInRange) {
                group.unshift(firstInRange);
                ignoreFirst = true;
            }
            // Likewise for the last one.
            if (group[group.length - 1] !== lastInRange) {
                group.push(lastInRange);
                ignoreLast = true;
            }
            group.forEach(function (current, index) {
                // Get the current step and the lower + upper positions.
                var step;
                var i;
                var q;
                var low = current;
                var high = group[index + 1];
                var newPct;
                var pctDifference;
                var pctPos;
                var type;
                var steps;
                var realSteps;
                var stepSize;
                var isSteps = mode === "steps";
                // When using 'steps' mode, use the provided steps.
                // Otherwise, we'll step on to the next subrange.
                if (isSteps) {
                    step = scope_Spectrum.xNumSteps[index];
                }
                // Default to a 'full' step.
                if (!step) {
                    step = high - low;
                }
                // Low can be 0, so test for false. Index 0 is already handled.
                if (low === false) {
                    return;
                }
                // If high is undefined we are at the last subrange. Make sure it iterates once (#1088)
                if (high === undefined) {
                    high = low;
                }
                // Make sure step isn't 0, which would cause an infinite loop (#654)
                step = Math.max(step, 0.0000001);
                // Find all steps in the subrange.
                for (i = low; i <= high; i = safeIncrement(i, step)) {
                    // Get the percentage value for the current step,
                    // calculate the size for the subrange.
                    newPct = scope_Spectrum.toStepping(i);
                    pctDifference = newPct - prevPct;
                    steps = pctDifference / density;
                    realSteps = Math.round(steps);
                    // This ratio represents the amount of percentage-space a point indicates.
                    // For a density 1 the points/percentage = 1. For density 2, that percentage needs to be re-divided.
                    // Round the percentage offset to an even number, then divide by two
                    // to spread the offset on both sides of the range.
                    stepSize = pctDifference / realSteps;
                    // Divide all points evenly, adding the correct number to this subrange.
                    // Run up to <= so that 100% gets a point, event if ignoreLast is set.
                    for (q = 1; q <= realSteps; q += 1) {
                        // The ratio between the rounded value and the actual size might be ~1% off.
                        // Correct the percentage offset by the number of points
                        // per subrange. density = 1 will result in 100 points on the
                        // full range, 2 for 50, 4 for 25, etc.
                        pctPos = prevPct + q * stepSize;
                        indexes[pctPos.toFixed(5)] = [scope_Spectrum.fromStepping(pctPos), 0];
                    }
                    // Determine the point type.
                    type = group.indexOf(i) > -1 ? PIPS_LARGE_VALUE : isSteps ? PIPS_SMALL_VALUE : PIPS_NO_VALUE;
                    // Enforce the 'ignoreFirst' option by overwriting the type for 0.
                    if (!index && ignoreFirst && i !== high) {
                        type = 0;
                    }
                    if (!(i === high && ignoreLast)) {
                        // Mark the 'type' of this point. 0 = plain, 1 = real value, 2 = step value.
                        indexes[newPct.toFixed(5)] = [i, type];
                    }
                    // Update the percentage count.
                    prevPct = newPct;
                }
            });
            return indexes;
        }
        function addMarking(spread, filterFunc, formatter) {
            var element = scope_Document.createElement("div");
            var valueSizeClasses = [];
            valueSizeClasses[PIPS_NO_VALUE] = options.cssClasses.valueNormal;
            valueSizeClasses[PIPS_LARGE_VALUE] = options.cssClasses.valueLarge;
            valueSizeClasses[PIPS_SMALL_VALUE] = options.cssClasses.valueSub;
            var markerSizeClasses = [];
            markerSizeClasses[PIPS_NO_VALUE] = options.cssClasses.markerNormal;
            markerSizeClasses[PIPS_LARGE_VALUE] = options.cssClasses.markerLarge;
            markerSizeClasses[PIPS_SMALL_VALUE] = options.cssClasses.markerSub;
            var valueOrientationClasses = [options.cssClasses.valueHorizontal, options.cssClasses.valueVertical];
            var markerOrientationClasses = [options.cssClasses.markerHorizontal, options.cssClasses.markerVertical];
            addClass(element, options.cssClasses.pips);
            addClass(element, options.ort === 0 ? options.cssClasses.pipsHorizontal : options.cssClasses.pipsVertical);
            function getClasses(type, source) {
                var a = source === options.cssClasses.value;
                var orientationClasses = a ? valueOrientationClasses : markerOrientationClasses;
                var sizeClasses = a ? valueSizeClasses : markerSizeClasses;
                return source + " " + orientationClasses[options.ort] + " " + sizeClasses[type];
            }
            function addSpread(offset, value, type) {
                // Apply the filter function, if it is set.
                type = filterFunc ? filterFunc(value, type) : type;
                if (type === PIPS_NONE) {
                    return;
                }
                // Add a marker for every point
                var node = addNodeTo(element, false);
                node.className = getClasses(type, options.cssClasses.marker);
                node.style[options.style] = offset + "%";
                // Values are only appended for points marked '1' or '2'.
                if (type > PIPS_NO_VALUE) {
                    node = addNodeTo(element, false);
                    node.className = getClasses(type, options.cssClasses.value);
                    node.setAttribute("data-value", value);
                    node.style[options.style] = offset + "%";
                    node.innerHTML = formatter.to(value);
                }
            }
            // Append all points.
            Object.keys(spread).forEach(function (offset) {
                addSpread(offset, spread[offset][0], spread[offset][1]);
            });
            return element;
        }
        function removePips() {
            if (scope_Pips) {
                removeElement(scope_Pips);
                scope_Pips = null;
            }
        }
        function pips(grid) {
            // Fix #669
            removePips();
            var mode = grid.mode;
            var density = grid.density || 1;
            var filter = grid.filter || false;
            var values = grid.values || false;
            var stepped = grid.stepped || false;
            var group = getGroup(mode, values, stepped);
            var spread = generateSpread(density, mode, group);
            var format = grid.format || {
                to: Math.round
            };
            scope_Pips = scope_Target.appendChild(addMarking(spread, filter, format));
            return scope_Pips;
        }
        // Shorthand for base dimensions.
        function baseSize() {
            var rect = scope_Base.getBoundingClientRect();
            var alt = "offset" + ["Width", "Height"][options.ort];
            return options.ort === 0 ? rect.width || scope_Base[alt] : rect.height || scope_Base[alt];
        }
        // Handler for attaching events trough a proxy.
        function attachEvent(events, element, callback, data) {
            // This function can be used to 'filter' events to the slider.
            // element is a node, not a nodeList
            var method = function (e) {
                e = fixEvent(e, data.pageOffset, data.target || element);
                // fixEvent returns false if this event has a different target
                // when handling (multi-) touch events;
                if (!e) {
                    return false;
                }
                // doNotReject is passed by all end events to make sure released touches
                // are not rejected, leaving the slider "stuck" to the cursor;
                if (isSliderDisabled() && !data.doNotReject) {
                    return false;
                }
                // Stop if an active 'tap' transition is taking place.
                if (hasClass(scope_Target, options.cssClasses.tap) && !data.doNotReject) {
                    return false;
                }
                // Ignore right or middle clicks on start #454
                if (events === actions.start && e.buttons !== undefined && e.buttons > 1) {
                    return false;
                }
                // Ignore right or middle clicks on start #454
                if (data.hover && e.buttons) {
                    return false;
                }
                // 'supportsPassive' is only true if a browser also supports touch-action: none in CSS.
                // iOS safari does not, so it doesn't get to benefit from passive scrolling. iOS does support
                // touch-action: manipulation, but that allows panning, which breaks
                // sliders after zooming/on non-responsive pages.
                // See: https://bugs.webkit.org/show_bug.cgi?id=133112
                if (!supportsPassive) {
                    e.preventDefault();
                }
                e.calcPoint = e.points[options.ort];
                // Call the event handler with the event [ and additional data ].
                callback(e, data);
            };
            var methods = [];
            // Bind a closure on the target for every event type.
            events.split(" ").forEach(function (eventName) {
                element.addEventListener(eventName, method, supportsPassive ? { passive: true } : false);
                methods.push([eventName, method]);
            });
            return methods;
        }
        // Provide a clean event with standardized offset values.
        function fixEvent(e, pageOffset, eventTarget) {
            // Filter the event to register the type, which can be
            // touch, mouse or pointer. Offset changes need to be
            // made on an event specific basis.
            var touch = e.type.indexOf("touch") === 0;
            var mouse = e.type.indexOf("mouse") === 0;
            var pointer = e.type.indexOf("pointer") === 0;
            var x;
            var y;
            // IE10 implemented pointer events with a prefix;
            if (e.type.indexOf("MSPointer") === 0) {
                pointer = true;
            }
            // Erroneous events seem to be passed in occasionally on iOS/iPadOS after user finishes interacting with
            // the slider. They appear to be of type MouseEvent, yet they don't have usual properties set. Ignore
            // events that have no touches or buttons associated with them. (#1057, #1079, #1095)
            if (e.type === "mousedown" && !e.buttons && !e.touches) {
                return false;
            }
            // The only thing one handle should be concerned about is the touches that originated on top of it.
            if (touch) {
                // Returns true if a touch originated on the target.
                var isTouchOnTarget = function (checkTouch) {
                    return (checkTouch.target === eventTarget ||
                        eventTarget.contains(checkTouch.target) ||
                        (checkTouch.target.shadowRoot && checkTouch.target.shadowRoot.contains(eventTarget)));
                };
                // In the case of touchstart events, we need to make sure there is still no more than one
                // touch on the target so we look amongst all touches.
                if (e.type === "touchstart") {
                    var targetTouches = Array.prototype.filter.call(e.touches, isTouchOnTarget);
                    // Do not support more than one touch per handle.
                    if (targetTouches.length > 1) {
                        return false;
                    }
                    x = targetTouches[0].pageX;
                    y = targetTouches[0].pageY;
                }
                else {
                    // In the other cases, find on changedTouches is enough.
                    var targetTouch = Array.prototype.find.call(e.changedTouches, isTouchOnTarget);
                    // Cancel if the target touch has not moved.
                    if (!targetTouch) {
                        return false;
                    }
                    x = targetTouch.pageX;
                    y = targetTouch.pageY;
                }
            }
            pageOffset = pageOffset || getPageOffset(scope_Document);
            if (mouse || pointer) {
                x = e.clientX + pageOffset.x;
                y = e.clientY + pageOffset.y;
            }
            e.pageOffset = pageOffset;
            e.points = [x, y];
            e.cursor = mouse || pointer; // Fix #435
            return e;
        }
        // Translate a coordinate in the document to a percentage on the slider
        function calcPointToPercentage(calcPoint) {
            var location = calcPoint - offset(scope_Base, options.ort);
            var proposal = (location * 100) / baseSize();
            // Clamp proposal between 0% and 100%
            // Out-of-bound coordinates may occur when .noUi-base pseudo-elements
            // are used (e.g. contained handles feature)
            proposal = limit(proposal);
            return options.dir ? 100 - proposal : proposal;
        }
        // Find handle closest to a certain percentage on the slider
        function getClosestHandle(clickedPosition) {
            var smallestDifference = 100;
            var handleNumber = false;
            scope_Handles.forEach(function (handle, index) {
                // Disabled handles are ignored
                if (isHandleDisabled(index)) {
                    return;
                }
                var handlePosition = scope_Locations[index];
                var differenceWithThisHandle = Math.abs(handlePosition - clickedPosition);
                // Initial state
                var clickAtEdge = differenceWithThisHandle === 100 && smallestDifference === 100;
                // Difference with this handle is smaller than the previously checked handle
                var isCloser = differenceWithThisHandle < smallestDifference;
                var isCloserAfter = differenceWithThisHandle <= smallestDifference && clickedPosition > handlePosition;
                if (isCloser || isCloserAfter || clickAtEdge) {
                    handleNumber = index;
                    smallestDifference = differenceWithThisHandle;
                }
            });
            return handleNumber;
        }
        // Fire 'end' when a mouse or pen leaves the document.
        function documentLeave(event, data) {
            if (event.type === "mouseout" && event.target.nodeName === "HTML" && event.relatedTarget === null) {
                eventEnd(event, data);
            }
        }
        // Handle movement on document for handle and range drag.
        function eventMove(event, data) {
            // Fix #498
            // Check value of .buttons in 'start' to work around a bug in IE10 mobile (data.buttonsProperty).
            // https://connect.microsoft.com/IE/feedback/details/927005/mobile-ie10-windows-phone-buttons-property-of-pointermove-event-always-zero
            // IE9 has .buttons and .which zero on mousemove.
            // Firefox breaks the spec MDN defines.
            if (navigator.appVersion.indexOf("MSIE 9") === -1 && event.buttons === 0 && data.buttonsProperty !== 0) {
                return eventEnd(event, data);
            }
            // Check if we are moving up or down
            var movement = (options.dir ? -1 : 1) * (event.calcPoint - data.startCalcPoint);
            // Convert the movement into a percentage of the slider width/height
            var proposal = (movement * 100) / data.baseSize;
            moveHandles(movement > 0, proposal, data.locations, data.handleNumbers);
        }
        // Unbind move events on document, call callbacks.
        function eventEnd(event, data) {
            // The handle is no longer active, so remove the class.
            if (data.handle) {
                removeClass(data.handle, options.cssClasses.active);
                scope_ActiveHandlesCount -= 1;
            }
            // Unbind the move and end events, which are added on 'start'.
            data.listeners.forEach(function (c) {
                scope_DocumentElement.removeEventListener(c[0], c[1]);
            });
            if (scope_ActiveHandlesCount === 0) {
                // Remove dragging class.
                removeClass(scope_Target, options.cssClasses.drag);
                setZindex();
                // Remove cursor styles and text-selection events bound to the body.
                if (event.cursor) {
                    scope_Body.style.cursor = "";
                    scope_Body.removeEventListener("selectstart", preventDefault);
                }
            }
            data.handleNumbers.forEach(function (handleNumber) {
                fireEvent("change", handleNumber);
                fireEvent("set", handleNumber);
                fireEvent("end", handleNumber);
            });
        }
        // Bind move events on document.
        function eventStart(event, data) {
            // Ignore event if any handle is disabled
            if (data.handleNumbers.some(isHandleDisabled)) {
                return false;
            }
            var handle;
            if (data.handleNumbers.length === 1) {
                var handleOrigin = scope_Handles[data.handleNumbers[0]];
                handle = handleOrigin.children[0];
                scope_ActiveHandlesCount += 1;
                // Mark the handle as 'active' so it can be styled.
                addClass(handle, options.cssClasses.active);
            }
            // A drag should never propagate up to the 'tap' event.
            event.stopPropagation();
            // Record the event listeners.
            var listeners = [];
            // Attach the move and end events.
            var moveEvent = attachEvent(actions.move, scope_DocumentElement, eventMove, {
                // The event target has changed so we need to propagate the original one so that we keep
                // relying on it to extract target touches.
                target: event.target,
                handle: handle,
                listeners: listeners,
                startCalcPoint: event.calcPoint,
                baseSize: baseSize(),
                pageOffset: event.pageOffset,
                handleNumbers: data.handleNumbers,
                buttonsProperty: event.buttons,
                locations: scope_Locations.slice()
            });
            var endEvent = attachEvent(actions.end, scope_DocumentElement, eventEnd, {
                target: event.target,
                handle: handle,
                listeners: listeners,
                doNotReject: true,
                handleNumbers: data.handleNumbers
            });
            var outEvent = attachEvent("mouseout", scope_DocumentElement, documentLeave, {
                target: event.target,
                handle: handle,
                listeners: listeners,
                doNotReject: true,
                handleNumbers: data.handleNumbers
            });
            // We want to make sure we pushed the listeners in the listener list rather than creating
            // a new one as it has already been passed to the event handlers.
            listeners.push.apply(listeners, moveEvent.concat(endEvent, outEvent));
            // Text selection isn't an issue on touch devices,
            // so adding cursor styles can be skipped.
            if (event.cursor) {
                // Prevent the 'I' cursor and extend the range-drag cursor.
                scope_Body.style.cursor = getComputedStyle(event.target).cursor;
                // Mark the target with a dragging state.
                if (scope_Handles.length > 1) {
                    addClass(scope_Target, options.cssClasses.drag);
                }
                // Prevent text selection when dragging the handles.
                // In noUiSlider <= 9.2.0, this was handled by calling preventDefault on mouse/touch start/move,
                // which is scroll blocking. The selectstart event is supported by FireFox starting from version 52,
                // meaning the only holdout is iOS Safari. This doesn't matter: text selection isn't triggered there.
                // The 'cursor' flag is false.
                // See: http://caniuse.com/#search=selectstart
                scope_Body.addEventListener("selectstart", preventDefault, false);
            }
            data.handleNumbers.forEach(function (handleNumber) {
                fireEvent("start", handleNumber);
            });
        }
        // Move closest handle to tapped location.
        function eventTap(event) {
            // The tap event shouldn't propagate up
            event.stopPropagation();
            var proposal = calcPointToPercentage(event.calcPoint);
            var handleNumber = getClosestHandle(proposal);
            // Tackle the case that all handles are 'disabled'.
            if (handleNumber === false) {
                return false;
            }
            // Flag the slider as it is now in a transitional state.
            // Transition takes a configurable amount of ms (default 300). Re-enable the slider after that.
            if (!options.events.snap) {
                addClassFor(scope_Target, options.cssClasses.tap, options.animationDuration);
            }
            setHandle(handleNumber, proposal, true, true);
            setZindex();
            fireEvent("slide", handleNumber, true);
            fireEvent("update", handleNumber, true);
            fireEvent("change", handleNumber, true);
            fireEvent("set", handleNumber, true);
            if (options.events.snap) {
                eventStart(event, { handleNumbers: [handleNumber] });
            }
        }
        // Fires a 'hover' event for a hovered mouse/pen position.
        function eventHover(event) {
            var proposal = calcPointToPercentage(event.calcPoint);
            var to = scope_Spectrum.getStep(proposal);
            var value = scope_Spectrum.fromStepping(to);
            Object.keys(scope_Events).forEach(function (targetEvent) {
                if ("hover" === targetEvent.split(".")[0]) {
                    scope_Events[targetEvent].forEach(function (callback) {
                        callback.call(scope_Self, value);
                    });
                }
            });
        }
        // Handles keydown on focused handles
        // Don't move the document when pressing arrow keys on focused handles
        function eventKeydown(event, handleNumber) {
            if (isSliderDisabled() || isHandleDisabled(handleNumber)) {
                return false;
            }
            var horizontalKeys = ["Left", "Right"];
            var verticalKeys = ["Down", "Up"];
            var largeStepKeys = ["PageDown", "PageUp"];
            var edgeKeys = ["Home", "End"];
            if (options.dir && !options.ort) {
                // On an right-to-left slider, the left and right keys act inverted
                horizontalKeys.reverse();
            }
            else if (options.ort && !options.dir) {
                // On a top-to-bottom slider, the up and down keys act inverted
                verticalKeys.reverse();
                largeStepKeys.reverse();
            }
            // Strip "Arrow" for IE compatibility. https://developer.mozilla.org/en-US/docs/Web/API/KeyboardEvent/key
            var key = event.key.replace("Arrow", "");
            var isLargeDown = key === largeStepKeys[0];
            var isLargeUp = key === largeStepKeys[1];
            var isDown = key === verticalKeys[0] || key === horizontalKeys[0] || isLargeDown;
            var isUp = key === verticalKeys[1] || key === horizontalKeys[1] || isLargeUp;
            var isMin = key === edgeKeys[0];
            var isMax = key === edgeKeys[1];
            if (!isDown && !isUp && !isMin && !isMax) {
                return true;
            }
            event.preventDefault();
            var to;
            if (isUp || isDown) {
                var multiplier = options.keyboardPageMultiplier;
                var direction = isDown ? 0 : 1;
                var steps = getNextStepsForHandle(handleNumber);
                var step = steps[direction];
                // At the edge of a slider, do nothing
                if (step === null) {
                    return false;
                }
                // No step set, use the default of 10% of the sub-range
                if (step === false) {
                    step = scope_Spectrum.getDefaultStep(scope_Locations[handleNumber], isDown, options.keyboardDefaultStep);
                }
                if (isLargeUp || isLargeDown) {
                    step *= multiplier;
                }
                // Step over zero-length ranges (#948);
                step = Math.max(step, 0.0000001);
                // Decrement for down steps
                step = (isDown ? -1 : 1) * step;
                to = scope_Values[handleNumber] + step;
            }
            else if (isMax) {
                // End key
                to = options.spectrum.xVal[options.spectrum.xVal.length - 1];
            }
            else {
                // Home key
                to = options.spectrum.xVal[0];
            }
            setHandle(handleNumber, scope_Spectrum.toStepping(to), true, true);
            fireEvent("slide", handleNumber);
            fireEvent("update", handleNumber);
            fireEvent("change", handleNumber);
            fireEvent("set", handleNumber);
            return false;
        }
        // Attach events to several slider parts.
        function bindSliderEvents(behaviour) {
            // Attach the standard drag event to the handles.
            if (!behaviour.fixed) {
                scope_Handles.forEach(function (handle, index) {
                    // These events are only bound to the visual handle
                    // element, not the 'real' origin element.
                    attachEvent(actions.start, handle.children[0], eventStart, {
                        handleNumbers: [index]
                    });
                });
            }
            // Attach the tap event to the slider base.
            if (behaviour.tap) {
                attachEvent(actions.start, scope_Base, eventTap, {});
            }
            // Fire hover events
            if (behaviour.hover) {
                attachEvent(actions.move, scope_Base, eventHover, {
                    hover: true
                });
            }
            // Make the range draggable.
            if (behaviour.drag) {
                scope_Connects.forEach(function (connect, index) {
                    if (connect === false || index === 0 || index === scope_Connects.length - 1) {
                        return;
                    }
                    var handleBefore = scope_Handles[index - 1];
                    var handleAfter = scope_Handles[index];
                    var eventHolders = [connect];
                    addClass(connect, options.cssClasses.draggable);
                    // When the range is fixed, the entire range can
                    // be dragged by the handles. The handle in the first
                    // origin will propagate the start event upward,
                    // but it needs to be bound manually on the other.
                    if (behaviour.fixed) {
                        eventHolders.push(handleBefore.children[0]);
                        eventHolders.push(handleAfter.children[0]);
                    }
                    eventHolders.forEach(function (eventHolder) {
                        attachEvent(actions.start, eventHolder, eventStart, {
                            handles: [handleBefore, handleAfter],
                            handleNumbers: [index - 1, index]
                        });
                    });
                });
            }
        }
        // Attach an event to this slider, possibly including a namespace
        function bindEvent(namespacedEvent, callback) {
            scope_Events[namespacedEvent] = scope_Events[namespacedEvent] || [];
            scope_Events[namespacedEvent].push(callback);
            // If the event bound is 'update,' fire it immediately for all handles.
            if (namespacedEvent.split(".")[0] === "update") {
                scope_Handles.forEach(function (a, index) {
                    fireEvent("update", index);
                });
            }
        }
        function isInternalNamespace(namespace) {
            return namespace === INTERNAL_EVENT_NS.aria || namespace === INTERNAL_EVENT_NS.tooltips;
        }
        // Undo attachment of event
        function removeEvent(namespacedEvent) {
            var event = namespacedEvent && namespacedEvent.split(".")[0];
            var namespace = event ? namespacedEvent.substring(event.length) : namespacedEvent;
            Object.keys(scope_Events).forEach(function (bind) {
                var tEvent = bind.split(".")[0];
                var tNamespace = bind.substring(tEvent.length);
                if ((!event || event === tEvent) && (!namespace || namespace === tNamespace)) {
                    // only delete protected internal event if intentional
                    if (!isInternalNamespace(tNamespace) || namespace === tNamespace) {
                        delete scope_Events[bind];
                    }
                }
            });
        }
        // External event handling
        function fireEvent(eventName, handleNumber, tap) {
            Object.keys(scope_Events).forEach(function (targetEvent) {
                var eventType = targetEvent.split(".")[0];
                if (eventName === eventType) {
                    scope_Events[targetEvent].forEach(function (callback) {
                        callback.call(
                            // Use the slider public API as the scope ('this')
                            scope_Self,
                            // Return values as array, so arg_1[arg_2] is always valid.
                            scope_Values.map(options.format.to),
                            // Handle index, 0 or 1
                            handleNumber,
                            // Un-formatted slider values
                            scope_Values.slice(),
                            // Event is fired by tap, true or false
                            tap || false,
                            // Left offset of the handle, in relation to the slider
                            scope_Locations.slice(),
                            // add the slider public API to an accessible parameter when this is unavailable
                            scope_Self);
                    });
                }
            });
        }
        // Split out the handle positioning logic so the Move event can use it, too
        function checkHandlePosition(reference, handleNumber, to, lookBackward, lookForward, getValue) {
            var distance;
            // For sliders with multiple handles, limit movement to the other handle.
            // Apply the margin option by adding it to the handle positions.
            if (scope_Handles.length > 1 && !options.events.unconstrained) {
                if (lookBackward && handleNumber > 0) {
                    distance = scope_Spectrum.getAbsoluteDistance(reference[handleNumber - 1], options.margin, 0);
                    to = Math.max(to, distance);
                }
                if (lookForward && handleNumber < scope_Handles.length - 1) {
                    distance = scope_Spectrum.getAbsoluteDistance(reference[handleNumber + 1], options.margin, 1);
                    to = Math.min(to, distance);
                }
            }
            // The limit option has the opposite effect, limiting handles to a
            // maximum distance from another. Limit must be > 0, as otherwise
            // handles would be unmovable.
            if (scope_Handles.length > 1 && options.limit) {
                if (lookBackward && handleNumber > 0) {
                    distance = scope_Spectrum.getAbsoluteDistance(reference[handleNumber - 1], options.limit, 0);
                    to = Math.min(to, distance);
                }
                if (lookForward && handleNumber < scope_Handles.length - 1) {
                    distance = scope_Spectrum.getAbsoluteDistance(reference[handleNumber + 1], options.limit, 1);
                    to = Math.max(to, distance);
                }
            }
            // The padding option keeps the handles a certain distance from the
            // edges of the slider. Padding must be > 0.
            if (options.padding) {
                if (handleNumber === 0) {
                    distance = scope_Spectrum.getAbsoluteDistance(0, options.padding[0], 0);
                    to = Math.max(to, distance);
                }
                if (handleNumber === scope_Handles.length - 1) {
                    distance = scope_Spectrum.getAbsoluteDistance(100, options.padding[1], 1);
                    to = Math.min(to, distance);
                }
            }
            to = scope_Spectrum.getStep(to);
            // Limit percentage to the 0 - 100 range
            to = limit(to);
            // Return false if handle can't move
            if (to === reference[handleNumber] && !getValue) {
                return false;
            }
            return to;
        }
        // Uses slider orientation to create CSS rules. a = base value;
        function inRuleOrder(v, a) {
            var o = options.ort;
            return (o ? a : v) + ", " + (o ? v : a);
        }
        // Moves handle(s) by a percentage
        // (bool, % to move, [% where handle started, ...], [index in scope_Handles, ...])
        function moveHandles(upward, proposal, locations, handleNumbers) {
            var proposals = locations.slice();
            var b = [!upward, upward];
            var f = [upward, !upward];
            // Copy handleNumbers so we don't change the dataset
            handleNumbers = handleNumbers.slice();
            // Check to see which handle is 'leading'.
            // If that one can't move the second can't either.
            if (upward) {
                handleNumbers.reverse();
            }
            // Step 1: get the maximum percentage that any of the handles can move
            if (handleNumbers.length > 1) {
                handleNumbers.forEach(function (handleNumber, o) {
                    var to = checkHandlePosition(proposals, handleNumber, proposals[handleNumber] + proposal, b[o], f[o], false);
                    // Stop if one of the handles can't move.
                    if (to === false) {
                        proposal = 0;
                    }
                    else {
                        proposal = to - proposals[handleNumber];
                        proposals[handleNumber] = to;
                    }
                });
            }
            // If using one handle, check backward AND forward
            else {
                b = f = [true];
            }
            var state = false;
            // Step 2: Try to set the handles with the found percentage
            handleNumbers.forEach(function (handleNumber, o) {
                state = setHandle(handleNumber, locations[handleNumber] + proposal, b[o], f[o]) || state;
            });
            // Step 3: If a handle moved, fire events
            if (state) {
                handleNumbers.forEach(function (handleNumber) {
                    fireEvent("update", handleNumber);
                    fireEvent("slide", handleNumber);
                });
            }
        }
        // Takes a base value and an offset. This offset is used for the connect bar size.
        // In the initial design for this feature, the origin element was 1% wide.
        // Unfortunately, a rounding bug in Chrome makes it impossible to implement this feature
        // in this manner: https://bugs.chromium.org/p/chromium/issues/detail?id=798223
        function transformDirection(a, b) {
            return options.dir ? 100 - a - b : a;
        }
        // Updates scope_Locations and scope_Values, updates visual state
        function updateHandlePosition(handleNumber, to) {
            // Update locations.
            scope_Locations[handleNumber] = to;
            // Convert the value to the slider stepping/range.
            scope_Values[handleNumber] = scope_Spectrum.fromStepping(to);
            var translation = 10 * (transformDirection(to, 0) - scope_DirOffset);
            var translateRule = "translate(" + inRuleOrder(translation + "%", "0") + ")";
            scope_Handles[handleNumber].style[options.transformRule] = translateRule;
            updateConnect(handleNumber);
            updateConnect(handleNumber + 1);
        }
        // Handles before the slider middle are stacked later = higher,
        // Handles after the middle later is lower
        // [[7] [8] .......... | .......... [5] [4]
        function setZindex() {
            scope_HandleNumbers.forEach(function (handleNumber) {
                var dir = scope_Locations[handleNumber] > 50 ? -1 : 1;
                var zIndex = 3 + (scope_Handles.length + dir * handleNumber);
                scope_Handles[handleNumber].style.zIndex = zIndex;
            });
        }
        // Test suggested values and apply margin, step.
        // if exactInput is true, don't run checkHandlePosition, then the handle can be placed in between steps (#436)
        function setHandle(handleNumber, to, lookBackward, lookForward, exactInput) {
            if (!exactInput) {
                to = checkHandlePosition(scope_Locations, handleNumber, to, lookBackward, lookForward, false);
            }
            if (to === false) {
                return false;
            }
            updateHandlePosition(handleNumber, to);
            return true;
        }
        // Updates style attribute for connect nodes
        function updateConnect(index) {
            // Skip connects set to false
            if (!scope_Connects[index]) {
                return;
            }
            var l = 0;
            var h = 100;
            if (index !== 0) {
                l = scope_Locations[index - 1];
            }
            if (index !== scope_Connects.length - 1) {
                h = scope_Locations[index];
            }
            // We use two rules:
            // 'translate' to change the left/top offset;
            // 'scale' to change the width of the element;
            // As the element has a width of 100%, a translation of 100% is equal to 100% of the parent (.noUi-base)
            var connectWidth = h - l;
            var translateRule = "translate(" + inRuleOrder(transformDirection(l, connectWidth) + "%", "0") + ")";
            var scaleRule = "scale(" + inRuleOrder(connectWidth / 100, "1") + ")";
            scope_Connects[index].style[options.transformRule] = translateRule + " " + scaleRule;
        }
        // Parses value passed to .set method. Returns current value if not parse-able.
        function resolveToValue(to, handleNumber) {
            // Setting with null indicates an 'ignore'.
            // Inputting 'false' is invalid.
            if (to === null || to === false || to === undefined) {
                return scope_Locations[handleNumber];
            }
            // If a formatted number was passed, attempt to decode it.
            if (typeof to === "number") {
                to = String(to);
            }
            to = options.format.from(to);
            to = scope_Spectrum.toStepping(to);
            // If parsing the number failed, use the current value.
            if (to === false || isNaN(to)) {
                return scope_Locations[handleNumber];
            }
            return to;
        }
        // Set the slider value.
        function valueSet(input, fireSetEvent, exactInput) {
            var values = asArray(input);
            var isInit = scope_Locations[0] === undefined;
            // Event fires by default
            fireSetEvent = fireSetEvent === undefined ? true : !!fireSetEvent;
            // Animation is optional.
            // Make sure the initial values were set before using animated placement.
            if (options.animate && !isInit) {
                addClassFor(scope_Target, options.cssClasses.tap, options.animationDuration);
            }
            // First pass, without lookAhead but with lookBackward. Values are set from left to right.
            scope_HandleNumbers.forEach(function (handleNumber) {
                setHandle(handleNumber, resolveToValue(values[handleNumber], handleNumber), true, false, exactInput);
            });
            var i = scope_HandleNumbers.length === 1 ? 0 : 1;
            // Secondary passes. Now that all base values are set, apply constraints.
            // Iterate all handles to ensure constraints are applied for the entire slider (Issue #1009)
            for (; i < scope_HandleNumbers.length; ++i) {
                scope_HandleNumbers.forEach(function (handleNumber) {
                    setHandle(handleNumber, scope_Locations[handleNumber], true, true, exactInput);
                });
            }
            setZindex();
            scope_HandleNumbers.forEach(function (handleNumber) {
                fireEvent("update", handleNumber);
                // Fire the event only for handles that received a new value, as per #579
                if (values[handleNumber] !== null && fireSetEvent) {
                    fireEvent("set", handleNumber);
                }
            });
        }
        // Reset slider to initial values
        function valueReset(fireSetEvent) {
            valueSet(options.start, fireSetEvent);
        }
        // Set value for a single handle
        function valueSetHandle(handleNumber, value, fireSetEvent, exactInput) {
            // Ensure numeric input
            handleNumber = Number(handleNumber);
            if (!(handleNumber >= 0 && handleNumber < scope_HandleNumbers.length)) {
                throw new Error("noUiSlider (" + VERSION + "): invalid handle number, got: " + handleNumber);
            }
            // Look both backward and forward, since we don't want this handle to "push" other handles (#960);
            // The exactInput argument can be used to ignore slider stepping (#436)
            setHandle(handleNumber, resolveToValue(value, handleNumber), true, true, exactInput);
            fireEvent("update", handleNumber);
            if (fireSetEvent) {
                fireEvent("set", handleNumber);
            }
        }
        // Get the slider value.
        function valueGet() {
            var values = scope_Values.map(options.format.to);
            // If only one handle is used, return a single value.
            if (values.length === 1) {
                return values[0];
            }
            return values;
        }
        // Removes classes from the root and empties it.
        function destroy() {
            // remove protected internal listeners
            removeEvent(INTERNAL_EVENT_NS.aria);
            removeEvent(INTERNAL_EVENT_NS.tooltips);
            for (var key in options.cssClasses) {
                if (!options.cssClasses.hasOwnProperty(key)) {
                    continue;
                }
                removeClass(scope_Target, options.cssClasses[key]);
            }
            while (scope_Target.firstChild) {
                scope_Target.removeChild(scope_Target.firstChild);
            }
            delete scope_Target.noUiSlider;
        }
        function getNextStepsForHandle(handleNumber) {
            var location = scope_Locations[handleNumber];
            var nearbySteps = scope_Spectrum.getNearbySteps(location);
            var value = scope_Values[handleNumber];
            var increment = nearbySteps.thisStep.step;
            var decrement = null;
            // If snapped, directly use defined step value
            if (options.snap) {
                return [
                    value - nearbySteps.stepBefore.startValue || null,
                    nearbySteps.stepAfter.startValue - value || null
                ];
            }
            // If the next value in this step moves into the next step,
            // the increment is the start of the next step - the current value
            if (increment !== false) {
                if (value + increment > nearbySteps.stepAfter.startValue) {
                    increment = nearbySteps.stepAfter.startValue - value;
                }
            }
            // If the value is beyond the starting point
            if (value > nearbySteps.thisStep.startValue) {
                decrement = nearbySteps.thisStep.step;
            }
            else if (nearbySteps.stepBefore.step === false) {
                decrement = false;
            }
            // If a handle is at the start of a step, it always steps back into the previous step first
            else {
                decrement = value - nearbySteps.stepBefore.highestStep;
            }
            // Now, if at the slider edges, there is no in/decrement
            if (location === 100) {
                increment = null;
            }
            else if (location === 0) {
                decrement = null;
            }
            // As per #391, the comparison for the decrement step can have some rounding issues.
            var stepDecimals = scope_Spectrum.countStepDecimals();
            // Round per #391
            if (increment !== null && increment !== false) {
                increment = Number(increment.toFixed(stepDecimals));
            }
            if (decrement !== null && decrement !== false) {
                decrement = Number(decrement.toFixed(stepDecimals));
            }
            return [decrement, increment];
        }
        // Get the current step size for the slider.
        function getNextSteps() {
            return scope_HandleNumbers.map(getNextStepsForHandle);
        }
        // Updateable: margin, limit, padding, step, range, animate, snap
        function updateOptions(optionsToUpdate, fireSetEvent) {
            // Spectrum is created using the range, snap, direction and step options.
            // 'snap' and 'step' can be updated.
            // If 'snap' and 'step' are not passed, they should remain unchanged.
            var v = valueGet();
            var updateAble = [
                "margin",
                "limit",
                "padding",
                "range",
                "animate",
                "snap",
                "step",
                "format",
                "pips",
                "tooltips"
            ];
            // Only change options that we're actually passed to update.
            updateAble.forEach(function (name) {
                // Check for undefined. null removes the value.
                if (optionsToUpdate[name] !== undefined) {
                    originalOptions[name] = optionsToUpdate[name];
                }
            });
            var newOptions = testOptions(originalOptions);
            // Load new options into the slider state
            updateAble.forEach(function (name) {
                if (optionsToUpdate[name] !== undefined) {
                    options[name] = newOptions[name];
                }
            });
            scope_Spectrum = newOptions.spectrum;
            // Limit, margin and padding depend on the spectrum but are stored outside of it. (#677)
            options.margin = newOptions.margin;
            options.limit = newOptions.limit;
            options.padding = newOptions.padding;
            // Update pips, removes existing.
            if (options.pips) {
                pips(options.pips);
            }
            else {
                removePips();
            }
            // Update tooltips, removes existing.
            if (options.tooltips) {
                tooltips();
            }
            else {
                removeTooltips();
            }
            // Invalidate the current positioning so valueSet forces an update.
            scope_Locations = [];
            valueSet(isSet(optionsToUpdate.start) ? optionsToUpdate.start : v, fireSetEvent);
        }
        // Initialization steps
        function setupSlider() {
            // Create the base element, initialize HTML and set classes.
            // Add handles and connect elements.
            scope_Base = addSlider(scope_Target);
            addElements(options.connect, scope_Base);
            // Attach user events.
            bindSliderEvents(options.events);
            // Use the public value method to set the start values.
            valueSet(options.start);
            if (options.pips) {
                pips(options.pips);
            }
            if (options.tooltips) {
                tooltips();
            }
            aria();
        }
        setupSlider();
        // noinspection JSUnusedGlobalSymbols
        scope_Self = {
            destroy: destroy,
            steps: getNextSteps,
            on: bindEvent,
            off: removeEvent,
            get: valueGet,
            set: valueSet,
            setHandle: valueSetHandle,
            reset: valueReset,
            // Exposed for unit testing, don't use this in your application.
            __moveHandles: function (a, b, c) {
                moveHandles(a, b, scope_Locations, c);
            },
            options: originalOptions,
            updateOptions: updateOptions,
            target: scope_Target,
            removePips: removePips,
            removeTooltips: removeTooltips,
            getTooltips: function () {
                return scope_Tooltips;
            },
            getOrigins: function () {
                return scope_Handles;
            },
            pips: pips // Issue #594
        };
        return scope_Self;
    }
    // Run the standard initializer
    function initialize(target, originalOptions) {
        if (!target || !target.nodeName) {
            throw new Error("noUiSlider (" + VERSION + "): create requires a single element, got: " + target);
        }
        // Throw an error if the slider was already initialized.
        if (target.noUiSlider) {
            throw new Error("noUiSlider (" + VERSION + "): Slider was already initialized.");
        }
        // Test the options and create the slider environment;
        var options = testOptions(originalOptions);
        var api = scope(target, options, originalOptions);
        target.noUiSlider = api;
        return api;
    }
    // Use an object instead of a function for future expandability;
    return {
        // Exposed for unit testing, don't use this in your application.
        __spectrum: Spectrum,
        version: VERSION,
        // A reference to the default classes, allows global changes.
        // Use the cssClasses option for changes to one slider.
        cssClasses: cssClasses,
        create: initialize
    };
});

/*!
 * Bootstrap-select v1.13.14 (https://developer.snapappointments.com/bootstrap-select)
 *
 * Copyright 2012-2020 SnapAppointments, LLC
 * Licensed under MIT (https://github.com/snapappointments/bootstrap-select/blob/master/LICENSE)
 */

(function (root, factory) {
    if (root === undefined && window !== undefined) root = window;
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module unless amdModuleId is set
        define(["jquery"], function (a0) {
            return (factory(a0));
        });
    } else if (typeof module === 'object' && module.exports) {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node.
        module.exports = factory(require("jquery"));
    } else {
        factory(root["jQuery"]);
    }
}(this, function (jQuery) {

    (function ($) {
        'use strict';

        var DISALLOWED_ATTRIBUTES = ['sanitize', 'whiteList', 'sanitizeFn'];

        var uriAttrs = [
            'background',
            'cite',
            'href',
            'itemtype',
            'longdesc',
            'poster',
            'src',
            'xlink:href'
        ];

        var ARIA_ATTRIBUTE_PATTERN = /^aria-[\w-]*$/i;

        var DefaultWhitelist = {
            // Global attributes allowed on any supplied element below.
            '*': ['class', 'dir', 'id', 'lang', 'role', 'tabindex', 'style', ARIA_ATTRIBUTE_PATTERN],
            a: ['target', 'href', 'title', 'rel'],
            area: [],
            b: [],
            br: [],
            col: [],
            code: [],
            div: [],
            em: [],
            hr: [],
            h1: [],
            h2: [],
            h3: [],
            h4: [],
            h5: [],
            h6: [],
            i: [],
            img: ['src', 'alt', 'title', 'width', 'height'],
            li: [],
            ol: [],
            p: [],
            pre: [],
            s: [],
            small: [],
            span: [],
            sub: [],
            sup: [],
            strong: [],
            u: [],
            ul: []
        }

        /**
         * A pattern that recognizes a commonly useful subset of URLs that are safe.
         *
         * Shoutout to Angular 7 https://github.com/angular/angular/blob/7.2.4/packages/core/src/sanitization/url_sanitizer.ts
         */
        var SAFE_URL_PATTERN = /^(?:(?:https?|mailto|ftp|tel|file):|[^&:/?#]*(?:[/?#]|$))/gi;

        /**
         * A pattern that matches safe data URLs. Only matches image, video and audio types.
         *
         * Shoutout to Angular 7 https://github.com/angular/angular/blob/7.2.4/packages/core/src/sanitization/url_sanitizer.ts
         */
        var DATA_URL_PATTERN = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[a-z0-9+/]+=*$/i;

        function allowedAttribute (attr, allowedAttributeList) {
            var attrName = attr.nodeName.toLowerCase()

            if ($.inArray(attrName, allowedAttributeList) !== -1) {
                if ($.inArray(attrName, uriAttrs) !== -1) {
                    return Boolean(attr.nodeValue.match(SAFE_URL_PATTERN) || attr.nodeValue.match(DATA_URL_PATTERN))
                }

                return true
            }

            var regExp = $(allowedAttributeList).filter(function (index, value) {
                return value instanceof RegExp
            })

            // Check if a regular expression validates the attribute.
            for (var i = 0, l = regExp.length; i < l; i++) {
                if (attrName.match(regExp[i])) {
                    return true
                }
            }

            return false
        }

        function sanitizeHtml (unsafeElements, whiteList, sanitizeFn) {
            if (sanitizeFn && typeof sanitizeFn === 'function') {
                return sanitizeFn(unsafeElements);
            }

            var whitelistKeys = Object.keys(whiteList);

            for (var i = 0, len = unsafeElements.length; i < len; i++) {
                var elements = unsafeElements[i].querySelectorAll('*');

                for (var j = 0, len2 = elements.length; j < len2; j++) {
                    var el = elements[j];
                    var elName = el.nodeName.toLowerCase();

                    if (whitelistKeys.indexOf(elName) === -1) {
                        el.parentNode.removeChild(el);

                        continue;
                    }

                    var attributeList = [].slice.call(el.attributes);
                    var whitelistedAttributes = [].concat(whiteList['*'] || [], whiteList[elName] || []);

                    for (var k = 0, len3 = attributeList.length; k < len3; k++) {
                        var attr = attributeList[k];

                        if (!allowedAttribute(attr, whitelistedAttributes)) {
                            el.removeAttribute(attr.nodeName);
                        }
                    }
                }
            }
        }

        // Polyfill for browsers with no classList support
        // Remove in v2
        if (!('classList' in document.createElement('_'))) {
            (function (view) {
                if (!('Element' in view)) return;

                var classListProp = 'classList',
                    protoProp = 'prototype',
                    elemCtrProto = view.Element[protoProp],
                    objCtr = Object,
                    classListGetter = function () {
                        var $elem = $(this);

                        return {
                            add: function (classes) {
                                classes = Array.prototype.slice.call(arguments).join(' ');
                                return $elem.addClass(classes);
                            },
                            remove: function (classes) {
                                classes = Array.prototype.slice.call(arguments).join(' ');
                                return $elem.removeClass(classes);
                            },
                            toggle: function (classes, force) {
                                return $elem.toggleClass(classes, force);
                            },
                            contains: function (classes) {
                                return $elem.hasClass(classes);
                            }
                        }
                    };

                if (objCtr.defineProperty) {
                    var classListPropDesc = {
                        get: classListGetter,
                        enumerable: true,
                        configurable: true
                    };
                    try {
                        objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
                    } catch (ex) { // IE 8 doesn't support enumerable:true
                        // adding undefined to fight this issue https://github.com/eligrey/classList.js/issues/36
                        // modernie IE8-MSW7 machine has IE8 8.0.6001.18702 and is affected
                        if (ex.number === undefined || ex.number === -0x7FF5EC54) {
                            classListPropDesc.enumerable = false;
                            objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
                        }
                    }
                } else if (objCtr[protoProp].__defineGetter__) {
                    elemCtrProto.__defineGetter__(classListProp, classListGetter);
                }
            }(window));
        }

        var testElement = document.createElement('_');

        testElement.classList.add('c1', 'c2');

        if (!testElement.classList.contains('c2')) {
            var _add = DOMTokenList.prototype.add,
                _remove = DOMTokenList.prototype.remove;

            DOMTokenList.prototype.add = function () {
                Array.prototype.forEach.call(arguments, _add.bind(this));
            }

            DOMTokenList.prototype.remove = function () {
                Array.prototype.forEach.call(arguments, _remove.bind(this));
            }
        }

        testElement.classList.toggle('c3', false);

        // Polyfill for IE 10 and Firefox <24, where classList.toggle does not
        // support the second argument.
        if (testElement.classList.contains('c3')) {
            var _toggle = DOMTokenList.prototype.toggle;

            DOMTokenList.prototype.toggle = function (token, force) {
                if (1 in arguments && !this.contains(token) === !force) {
                    return force;
                } else {
                    return _toggle.call(this, token);
                }
            };
        }

        testElement = null;

        // shallow array comparison
        function isEqual (array1, array2) {
            return array1.length === array2.length && array1.every(function (element, index) {
                return element === array2[index];
            });
        };

        // <editor-fold desc="Shims">
        if (!String.prototype.startsWith) {
            (function () {
                'use strict'; // needed to support `apply`/`call` with `undefined`/`null`
                var defineProperty = (function () {
                    // IE 8 only supports `Object.defineProperty` on DOM elements
                    try {
                        var object = {};
                        var $defineProperty = Object.defineProperty;
                        var result = $defineProperty(object, object, object) && $defineProperty;
                    } catch (error) {
                    }
                    return result;
                }());
                var toString = {}.toString;
                var startsWith = function (search) {
                    if (this == null) {
                        throw new TypeError();
                    }
                    var string = String(this);
                    if (search && toString.call(search) == '[object RegExp]') {
                        throw new TypeError();
                    }
                    var stringLength = string.length;
                    var searchString = String(search);
                    var searchLength = searchString.length;
                    var position = arguments.length > 1 ? arguments[1] : undefined;
                    // `ToInteger`
                    var pos = position ? Number(position) : 0;
                    if (pos != pos) { // better `isNaN`
                        pos = 0;
                    }
                    var start = Math.min(Math.max(pos, 0), stringLength);
                    // Avoid the `indexOf` call if no match is possible
                    if (searchLength + start > stringLength) {
                        return false;
                    }
                    var index = -1;
                    while (++index < searchLength) {
                        if (string.charCodeAt(start + index) != searchString.charCodeAt(index)) {
                            return false;
                        }
                    }
                    return true;
                };
                if (defineProperty) {
                    defineProperty(String.prototype, 'startsWith', {
                        'value': startsWith,
                        'configurable': true,
                        'writable': true
                    });
                } else {
                    String.prototype.startsWith = startsWith;
                }
            }());
        }

        if (!Object.keys) {
            Object.keys = function (
                o, // object
                k, // key
                r  // result array
            ) {
                // initialize object and result
                r = [];
                // iterate over object keys
                for (k in o) {
                    // fill result array with non-prototypical keys
                    r.hasOwnProperty.call(o, k) && r.push(k);
                }
                // return result
                return r;
            };
        }

        if (HTMLSelectElement && !HTMLSelectElement.prototype.hasOwnProperty('selectedOptions')) {
            Object.defineProperty(HTMLSelectElement.prototype, 'selectedOptions', {
                get: function () {
                    return this.querySelectorAll(':checked');
                }
            });
        }

        function getSelectedOptions (select, ignoreDisabled) {
            var selectedOptions = select.selectedOptions,
                options = [],
                opt;

            if (ignoreDisabled) {
                for (var i = 0, len = selectedOptions.length; i < len; i++) {
                    opt = selectedOptions[i];

                    if (!(opt.disabled || opt.parentNode.tagName === 'OPTGROUP' && opt.parentNode.disabled)) {
                        options.push(opt);
                    }
                }

                return options;
            }

            return selectedOptions;
        }

        // much faster than $.val()
        function getSelectValues (select, selectedOptions) {
            var value = [],
                options = selectedOptions || select.selectedOptions,
                opt;

            for (var i = 0, len = options.length; i < len; i++) {
                opt = options[i];

                if (!(opt.disabled || opt.parentNode.tagName === 'OPTGROUP' && opt.parentNode.disabled)) {
                    value.push(opt.value);
                }
            }

            if (!select.multiple) {
                return !value.length ? null : value[0];
            }

            return value;
        }

        // set data-selected on select element if the value has been programmatically selected
        // prior to initialization of bootstrap-select
        // * consider removing or replacing an alternative method *
        var valHooks = {
            useDefault: false,
            _set: $.valHooks.select.set
        };

        $.valHooks.select.set = function (elem, value) {
            if (value && !valHooks.useDefault) $(elem).data('selected', true);

            return valHooks._set.apply(this, arguments);
        };

        var changedArguments = null;

        var EventIsSupported = (function () {
            try {
                new Event('change');
                return true;
            } catch (e) {
                return false;
            }
        })();

        $.fn.triggerNative = function (eventName) {
            var el = this[0],
                event;

            if (el.dispatchEvent) { // for modern browsers & IE9+
                if (EventIsSupported) {
                    // For modern browsers
                    event = new Event(eventName, {
                        bubbles: true
                    });
                } else {
                    // For IE since it doesn't support Event constructor
                    event = document.createEvent('Event');
                    event.initEvent(eventName, true, false);
                }

                el.dispatchEvent(event);
            } else if (el.fireEvent) { // for IE8
                event = document.createEventObject();
                event.eventType = eventName;
                el.fireEvent('on' + eventName, event);
            } else {
                // fall back to jQuery.trigger
                this.trigger(eventName);
            }
        };
        // </editor-fold>

        function stringSearch (li, searchString, method, normalize) {
            var stringTypes = [
                    'display',
                    'subtext',
                    'tokens'
                ],
                searchSuccess = false;

            for (var i = 0; i < stringTypes.length; i++) {
                var stringType = stringTypes[i],
                    string = li[stringType];

                if (string) {
                    string = string.toString();

                    // Strip HTML tags. This isn't perfect, but it's much faster than any other method
                    if (stringType === 'display') {
                        string = string.replace(/<[^>]+>/g, '');
                    }

                    if (normalize) string = normalizeToBase(string);
                    string = string.toUpperCase();

                    if (method === 'contains') {
                        searchSuccess = string.indexOf(searchString) >= 0;
                    } else {
                        searchSuccess = string.startsWith(searchString);
                    }

                    if (searchSuccess) break;
                }
            }

            return searchSuccess;
        }

        function toInteger (value) {
            return parseInt(value, 10) || 0;
        }

        // Borrowed from Lodash (_.deburr)
        /** Used to map Latin Unicode letters to basic Latin letters. */
        var deburredLetters = {
            // Latin-1 Supplement block.
            '\xc0': 'A',  '\xc1': 'A', '\xc2': 'A', '\xc3': 'A', '\xc4': 'A', '\xc5': 'A',
            '\xe0': 'a',  '\xe1': 'a', '\xe2': 'a', '\xe3': 'a', '\xe4': 'a', '\xe5': 'a',
            '\xc7': 'C',  '\xe7': 'c',
            '\xd0': 'D',  '\xf0': 'd',
            '\xc8': 'E',  '\xc9': 'E', '\xca': 'E', '\xcb': 'E',
            '\xe8': 'e',  '\xe9': 'e', '\xea': 'e', '\xeb': 'e',
            '\xcc': 'I',  '\xcd': 'I', '\xce': 'I', '\xcf': 'I',
            '\xec': 'i',  '\xed': 'i', '\xee': 'i', '\xef': 'i',
            '\xd1': 'N',  '\xf1': 'n',
            '\xd2': 'O',  '\xd3': 'O', '\xd4': 'O', '\xd5': 'O', '\xd6': 'O', '\xd8': 'O',
            '\xf2': 'o',  '\xf3': 'o', '\xf4': 'o', '\xf5': 'o', '\xf6': 'o', '\xf8': 'o',
            '\xd9': 'U',  '\xda': 'U', '\xdb': 'U', '\xdc': 'U',
            '\xf9': 'u',  '\xfa': 'u', '\xfb': 'u', '\xfc': 'u',
            '\xdd': 'Y',  '\xfd': 'y', '\xff': 'y',
            '\xc6': 'Ae', '\xe6': 'ae',
            '\xde': 'Th', '\xfe': 'th',
            '\xdf': 'ss',
            // Latin Extended-A block.
            '\u0100': 'A',  '\u0102': 'A', '\u0104': 'A',
            '\u0101': 'a',  '\u0103': 'a', '\u0105': 'a',
            '\u0106': 'C',  '\u0108': 'C', '\u010a': 'C', '\u010c': 'C',
            '\u0107': 'c',  '\u0109': 'c', '\u010b': 'c', '\u010d': 'c',
            '\u010e': 'D',  '\u0110': 'D', '\u010f': 'd', '\u0111': 'd',
            '\u0112': 'E',  '\u0114': 'E', '\u0116': 'E', '\u0118': 'E', '\u011a': 'E',
            '\u0113': 'e',  '\u0115': 'e', '\u0117': 'e', '\u0119': 'e', '\u011b': 'e',
            '\u011c': 'G',  '\u011e': 'G', '\u0120': 'G', '\u0122': 'G',
            '\u011d': 'g',  '\u011f': 'g', '\u0121': 'g', '\u0123': 'g',
            '\u0124': 'H',  '\u0126': 'H', '\u0125': 'h', '\u0127': 'h',
            '\u0128': 'I',  '\u012a': 'I', '\u012c': 'I', '\u012e': 'I', '\u0130': 'I',
            '\u0129': 'i',  '\u012b': 'i', '\u012d': 'i', '\u012f': 'i', '\u0131': 'i',
            '\u0134': 'J',  '\u0135': 'j',
            '\u0136': 'K',  '\u0137': 'k', '\u0138': 'k',
            '\u0139': 'L',  '\u013b': 'L', '\u013d': 'L', '\u013f': 'L', '\u0141': 'L',
            '\u013a': 'l',  '\u013c': 'l', '\u013e': 'l', '\u0140': 'l', '\u0142': 'l',
            '\u0143': 'N',  '\u0145': 'N', '\u0147': 'N', '\u014a': 'N',
            '\u0144': 'n',  '\u0146': 'n', '\u0148': 'n', '\u014b': 'n',
            '\u014c': 'O',  '\u014e': 'O', '\u0150': 'O',
            '\u014d': 'o',  '\u014f': 'o', '\u0151': 'o',
            '\u0154': 'R',  '\u0156': 'R', '\u0158': 'R',
            '\u0155': 'r',  '\u0157': 'r', '\u0159': 'r',
            '\u015a': 'S',  '\u015c': 'S', '\u015e': 'S', '\u0160': 'S',
            '\u015b': 's',  '\u015d': 's', '\u015f': 's', '\u0161': 's',
            '\u0162': 'T',  '\u0164': 'T', '\u0166': 'T',
            '\u0163': 't',  '\u0165': 't', '\u0167': 't',
            '\u0168': 'U',  '\u016a': 'U', '\u016c': 'U', '\u016e': 'U', '\u0170': 'U', '\u0172': 'U',
            '\u0169': 'u',  '\u016b': 'u', '\u016d': 'u', '\u016f': 'u', '\u0171': 'u', '\u0173': 'u',
            '\u0174': 'W',  '\u0175': 'w',
            '\u0176': 'Y',  '\u0177': 'y', '\u0178': 'Y',
            '\u0179': 'Z',  '\u017b': 'Z', '\u017d': 'Z',
            '\u017a': 'z',  '\u017c': 'z', '\u017e': 'z',
            '\u0132': 'IJ', '\u0133': 'ij',
            '\u0152': 'Oe', '\u0153': 'oe',
            '\u0149': "'n", '\u017f': 's'
        };

        /** Used to match Latin Unicode letters (excluding mathematical operators). */
        var reLatin = /[\xc0-\xd6\xd8-\xf6\xf8-\xff\u0100-\u017f]/g;

        /** Used to compose unicode character classes. */
        var rsComboMarksRange = '\\u0300-\\u036f',
            reComboHalfMarksRange = '\\ufe20-\\ufe2f',
            rsComboSymbolsRange = '\\u20d0-\\u20ff',
            rsComboMarksExtendedRange = '\\u1ab0-\\u1aff',
            rsComboMarksSupplementRange = '\\u1dc0-\\u1dff',
            rsComboRange = rsComboMarksRange + reComboHalfMarksRange + rsComboSymbolsRange + rsComboMarksExtendedRange + rsComboMarksSupplementRange;

        /** Used to compose unicode capture groups. */
        var rsCombo = '[' + rsComboRange + ']';

        /**
         * Used to match [combining diacritical marks](https://en.wikipedia.org/wiki/Combining_Diacritical_Marks) and
         * [combining diacritical marks for symbols](https://en.wikipedia.org/wiki/Combining_Diacritical_Marks_for_Symbols).
         */
        var reComboMark = RegExp(rsCombo, 'g');

        function deburrLetter (key) {
            return deburredLetters[key];
        };

        function normalizeToBase (string) {
            string = string.toString();
            return string && string.replace(reLatin, deburrLetter).replace(reComboMark, '');
        }

        // List of HTML entities for escaping.
        var escapeMap = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#x27;',
            '`': '&#x60;'
        };

        // Functions for escaping and unescaping strings to/from HTML interpolation.
        var createEscaper = function (map) {
            var escaper = function (match) {
                return map[match];
            };
            // Regexes for identifying a key that needs to be escaped.
            var source = '(?:' + Object.keys(map).join('|') + ')';
            var testRegexp = RegExp(source);
            var replaceRegexp = RegExp(source, 'g');
            return function (string) {
                string = string == null ? '' : '' + string;
                return testRegexp.test(string) ? string.replace(replaceRegexp, escaper) : string;
            };
        };

        var htmlEscape = createEscaper(escapeMap);

        /**
         * ------------------------------------------------------------------------
         * Constants
         * ------------------------------------------------------------------------
         */

        var keyCodeMap = {
            32: ' ',
            48: '0',
            49: '1',
            50: '2',
            51: '3',
            52: '4',
            53: '5',
            54: '6',
            55: '7',
            56: '8',
            57: '9',
            59: ';',
            65: 'A',
            66: 'B',
            67: 'C',
            68: 'D',
            69: 'E',
            70: 'F',
            71: 'G',
            72: 'H',
            73: 'I',
            74: 'J',
            75: 'K',
            76: 'L',
            77: 'M',
            78: 'N',
            79: 'O',
            80: 'P',
            81: 'Q',
            82: 'R',
            83: 'S',
            84: 'T',
            85: 'U',
            86: 'V',
            87: 'W',
            88: 'X',
            89: 'Y',
            90: 'Z',
            96: '0',
            97: '1',
            98: '2',
            99: '3',
            100: '4',
            101: '5',
            102: '6',
            103: '7',
            104: '8',
            105: '9'
        };

        var keyCodes = {
            ESCAPE: 27, // KeyboardEvent.which value for Escape (Esc) key
            ENTER: 13, // KeyboardEvent.which value for Enter key
            SPACE: 32, // KeyboardEvent.which value for space key
            TAB: 9, // KeyboardEvent.which value for tab key
            ARROW_UP: 38, // KeyboardEvent.which value for up arrow key
            ARROW_DOWN: 40 // KeyboardEvent.which value for down arrow key
        }

        var version = {
            success: false,
            major: '3'
        };

        try {
            version.full = ($.fn.dropdown.Constructor.VERSION || '').split(' ')[0].split('.');
            version.major = version.full[0];
            version.success = true;
        } catch (err) {
            // do nothing
        }

        var selectId = 0;

        var EVENT_KEY = '.bs.select';

        var classNames = {
            DISABLED: 'disabled',
            DIVIDER: 'divider',
            SHOW: 'open',
            DROPUP: 'dropup',
            MENU: 'dropdown-menu',
            MENURIGHT: 'dropdown-menu-right',
            MENULEFT: 'dropdown-menu-left',
            // to-do: replace with more advanced template/customization options
            BUTTONCLASS: 'btn-default',
            POPOVERHEADER: 'popover-title',
            ICONBASE: 'glyphicon',
            TICKICON: 'glyphicon-ok'
        }

        var Selector = {
            MENU: '.' + classNames.MENU
        }

        var elementTemplates = {
            span: document.createElement('span'),
            i: document.createElement('i'),
            subtext: document.createElement('small'),
            a: document.createElement('a'),
            li: document.createElement('li'),
            whitespace: document.createTextNode('\u00A0'),
            fragment: document.createDocumentFragment()
        }

        elementTemplates.a.setAttribute('role', 'option');
        if (version.major === '4') elementTemplates.a.className = 'dropdown-item';

        elementTemplates.subtext.className = 'text-muted';

        elementTemplates.text = elementTemplates.span.cloneNode(false);
        elementTemplates.text.className = 'text';

        elementTemplates.checkMark = elementTemplates.span.cloneNode(false);

        var REGEXP_ARROW = new RegExp(keyCodes.ARROW_UP + '|' + keyCodes.ARROW_DOWN);
        var REGEXP_TAB_OR_ESCAPE = new RegExp('^' + keyCodes.TAB + '$|' + keyCodes.ESCAPE);

        var generateOption = {
            li: function (content, classes, optgroup) {
                var li = elementTemplates.li.cloneNode(false);

                if (content) {
                    if (content.nodeType === 1 || content.nodeType === 11) {
                        li.appendChild(content);
                    } else {
                        li.innerHTML = content;
                    }
                }

                if (typeof classes !== 'undefined' && classes !== '') li.className = classes;
                if (typeof optgroup !== 'undefined' && optgroup !== null) li.classList.add('optgroup-' + optgroup);

                return li;
            },

            a: function (text, classes, inline) {
                var a = elementTemplates.a.cloneNode(true);

                if (text) {
                    if (text.nodeType === 11) {
                        a.appendChild(text);
                    } else {
                        a.insertAdjacentHTML('beforeend', text);
                    }
                }

                if (typeof classes !== 'undefined' && classes !== '') a.classList.add.apply(a.classList, classes.split(' '));
                if (inline) a.setAttribute('style', inline);

                return a;
            },

            text: function (options, useFragment) {
                var textElement = elementTemplates.text.cloneNode(false),
                    subtextElement,
                    iconElement;

                if (options.content) {
                    textElement.innerHTML = options.content;
                } else {
                    textElement.textContent = options.text;

                    if (options.icon) {
                        var whitespace = elementTemplates.whitespace.cloneNode(false);

                        // need to use <i> for icons in the button to prevent a breaking change
                        // note: switch to span in next major release
                        iconElement = (useFragment === true ? elementTemplates.i : elementTemplates.span).cloneNode(false);
                        iconElement.className = this.options.iconBase + ' ' + options.icon;

                        elementTemplates.fragment.appendChild(iconElement);
                        elementTemplates.fragment.appendChild(whitespace);
                    }

                    if (options.subtext) {
                        subtextElement = elementTemplates.subtext.cloneNode(false);
                        subtextElement.textContent = options.subtext;
                        textElement.appendChild(subtextElement);
                    }
                }

                if (useFragment === true) {
                    while (textElement.childNodes.length > 0) {
                        elementTemplates.fragment.appendChild(textElement.childNodes[0]);
                    }
                } else {
                    elementTemplates.fragment.appendChild(textElement);
                }

                return elementTemplates.fragment;
            },

            label: function (options) {
                var textElement = elementTemplates.text.cloneNode(false),
                    subtextElement,
                    iconElement;

                textElement.innerHTML = options.display;

                if (options.icon) {
                    var whitespace = elementTemplates.whitespace.cloneNode(false);

                    iconElement = elementTemplates.span.cloneNode(false);
                    iconElement.className = this.options.iconBase + ' ' + options.icon;

                    elementTemplates.fragment.appendChild(iconElement);
                    elementTemplates.fragment.appendChild(whitespace);
                }

                if (options.subtext) {
                    subtextElement = elementTemplates.subtext.cloneNode(false);
                    subtextElement.textContent = options.subtext;
                    textElement.appendChild(subtextElement);
                }

                elementTemplates.fragment.appendChild(textElement);

                return elementTemplates.fragment;
            }
        }

        var Selectpicker = function (element, options) {
            var that = this;

            // bootstrap-select has been initialized - revert valHooks.select.set back to its original function
            if (!valHooks.useDefault) {
                $.valHooks.select.set = valHooks._set;
                valHooks.useDefault = true;
            }

            this.$element = $(element);
            this.$newElement = null;
            this.$button = null;
            this.$menu = null;
            this.options = options;
            this.selectpicker = {
                main: {},
                search: {},
                current: {}, // current changes if a search is in progress
                view: {},
                isSearching: false,
                keydown: {
                    keyHistory: '',
                    resetKeyHistory: {
                        start: function () {
                            return setTimeout(function () {
                                that.selectpicker.keydown.keyHistory = '';
                            }, 800);
                        }
                    }
                }
            };

            this.sizeInfo = {};

            // If we have no title yet, try to pull it from the html title attribute (jQuery doesnt' pick it up as it's not a
            // data-attribute)
            if (this.options.title === null) {
                this.options.title = this.$element.attr('title');
            }

            // Format window padding
            var winPad = this.options.windowPadding;
            if (typeof winPad === 'number') {
                this.options.windowPadding = [winPad, winPad, winPad, winPad];
            }

            // Expose public methods
            this.val = Selectpicker.prototype.val;
            this.render = Selectpicker.prototype.render;
            this.refresh = Selectpicker.prototype.refresh;
            this.setStyle = Selectpicker.prototype.setStyle;
            this.selectAll = Selectpicker.prototype.selectAll;
            this.deselectAll = Selectpicker.prototype.deselectAll;
            this.destroy = Selectpicker.prototype.destroy;
            this.remove = Selectpicker.prototype.remove;
            this.show = Selectpicker.prototype.show;
            this.hide = Selectpicker.prototype.hide;

            this.init();
        };

        Selectpicker.VERSION = '1.13.14';

        // part of this is duplicated in i18n/defaults-en_US.js. Make sure to update both.
        Selectpicker.DEFAULTS = {
            noneSelectedText: 'Nothing selected',
            noneResultsText: 'No results matched {0}',
            countSelectedText: function (numSelected, numTotal) {
                return (numSelected == 1) ? '{0} item selected' : '{0} items selected';
            },
            maxOptionsText: function (numAll, numGroup) {
                return [
                    (numAll == 1) ? 'Limit reached ({n} item max)' : 'Limit reached ({n} items max)',
                    (numGroup == 1) ? 'Group limit reached ({n} item max)' : 'Group limit reached ({n} items max)'
                ];
            },
            selectAllText: 'Select All',
            deselectAllText: 'Deselect All',
            doneButton: false,
            doneButtonText: 'Close',
            multipleSeparator: ', ',
            styleBase: 'btn',
            style: classNames.BUTTONCLASS,
            size: 'auto',
            title: null,
            selectedTextFormat: 'values',
            width: false,
            container: false,
            hideDisabled: false,
            showSubtext: false,
            showIcon: true,
            showContent: true,
            dropupAuto: true,
            header: false,
            liveSearch: false,
            liveSearchPlaceholder: null,
            liveSearchNormalize: false,
            liveSearchStyle: 'contains',
            actionsBox: false,
            iconBase: classNames.ICONBASE,
            tickIcon: classNames.TICKICON,
            showTick: false,
            template: {
                caret: '<span class="caret"></span>'
            },
            maxOptions: false,
            mobile: false,
            selectOnTab: false,
            dropdownAlignRight: false,
            windowPadding: 0,
            virtualScroll: 600,
            display: false,
            sanitize: true,
            sanitizeFn: null,
            whiteList: DefaultWhitelist
        };

        Selectpicker.prototype = {

            constructor: Selectpicker,

            init: function () {
                var that = this,
                    id = this.$element.attr('id');

                selectId++;
                this.selectId = 'bs-select-' + selectId;

                this.$element[0].classList.add('bs-select-hidden');

                this.multiple = this.$element.prop('multiple');
                this.autofocus = this.$element.prop('autofocus');

                if (this.$element[0].classList.contains('show-tick')) {
                    this.options.showTick = true;
                }

                this.$newElement = this.createDropdown();
                this.buildData();
                this.$element
                    .after(this.$newElement)
                    .prependTo(this.$newElement);

                this.$button = this.$newElement.children('button');
                this.$menu = this.$newElement.children(Selector.MENU);
                this.$menuInner = this.$menu.children('.inner');
                this.$searchbox = this.$menu.find('input');

                this.$element[0].classList.remove('bs-select-hidden');

                if (this.options.dropdownAlignRight === true) this.$menu[0].classList.add(classNames.MENURIGHT);

                if (typeof id !== 'undefined') {
                    this.$button.attr('data-id', id);
                }

                this.checkDisabled();
                this.clickListener();

                if (this.options.liveSearch) {
                    this.liveSearchListener();
                    this.focusedParent = this.$searchbox[0];
                } else {
                    this.focusedParent = this.$menuInner[0];
                }

                this.setStyle();
                this.render();
                this.setWidth();
                if (this.options.container) {
                    this.selectPosition();
                } else {
                    this.$element.on('hide' + EVENT_KEY, function () {
                        if (that.isVirtual()) {
                            // empty menu on close
                            var menuInner = that.$menuInner[0],
                                emptyMenu = menuInner.firstChild.cloneNode(false);

                            // replace the existing UL with an empty one - this is faster than $.empty() or innerHTML = ''
                            menuInner.replaceChild(emptyMenu, menuInner.firstChild);
                            menuInner.scrollTop = 0;
                        }
                    });
                }
                this.$menu.data('this', this);
                this.$newElement.data('this', this);
                if (this.options.mobile) this.mobile();

                this.$newElement.on({
                    'hide.bs.dropdown': function (e) {
                        that.$element.trigger('hide' + EVENT_KEY, e);
                    },
                    'hidden.bs.dropdown': function (e) {
                        that.$element.trigger('hidden' + EVENT_KEY, e);
                    },
                    'show.bs.dropdown': function (e) {
                        that.$element.trigger('show' + EVENT_KEY, e);
                    },
                    'shown.bs.dropdown': function (e) {
                        that.$element.trigger('shown' + EVENT_KEY, e);
                    }
                });

                if (that.$element[0].hasAttribute('required')) {
                    this.$element.on('invalid' + EVENT_KEY, function () {
                        that.$button[0].classList.add('bs-invalid');

                        that.$element
                            .on('shown' + EVENT_KEY + '.invalid', function () {
                                that.$element
                                    .val(that.$element.val()) // set the value to hide the validation message in Chrome when menu is opened
                                    .off('shown' + EVENT_KEY + '.invalid');
                            })
                            .on('rendered' + EVENT_KEY, function () {
                                // if select is no longer invalid, remove the bs-invalid class
                                if (this.validity.valid) that.$button[0].classList.remove('bs-invalid');
                                that.$element.off('rendered' + EVENT_KEY);
                            });

                        that.$button.on('blur' + EVENT_KEY, function () {
                            that.$element.trigger('focus').trigger('blur');
                            that.$button.off('blur' + EVENT_KEY);
                        });
                    });
                }

                setTimeout(function () {
                    that.buildList();
                    that.$element.trigger('loaded' + EVENT_KEY);
                });
            },

            createDropdown: function () {
                // Options
                // If we are multiple or showTick option is set, then add the show-tick class
                var showTick = (this.multiple || this.options.showTick) ? ' show-tick' : '',
                    multiselectable = this.multiple ? ' aria-multiselectable="true"' : '',
                    inputGroup = '',
                    autofocus = this.autofocus ? ' autofocus' : '';

                if (version.major < 4 && this.$element.parent().hasClass('input-group')) {
                    inputGroup = ' input-group-btn';
                }

                // Elements
                var drop,
                    header = '',
                    searchbox = '',
                    actionsbox = '',
                    donebutton = '';

                if (this.options.header) {
                    header =
                        '<div class="' + classNames.POPOVERHEADER + '">' +
                        '<button type="button" class="close" aria-hidden="true">&times;</button>' +
                        this.options.header +
                        '</div>';
                }

                if (this.options.liveSearch) {
                    searchbox =
                        '<div class="bs-searchbox">' +
                        '<input type="search" class="form-control" autocomplete="off"' +
                        (
                            this.options.liveSearchPlaceholder === null ? ''
                                :
                                ' placeholder="' + htmlEscape(this.options.liveSearchPlaceholder) + '"'
                        ) +
                        ' role="combobox" aria-label="Search" aria-controls="' + this.selectId + '" aria-autocomplete="list">' +
                        '</div>';
                }

                if (this.multiple && this.options.actionsBox) {
                    actionsbox =
                        '<div class="bs-actionsbox">' +
                        '<div class="btn-group btn-group-sm btn-block">' +
                        '<button type="button" class="actions-btn bs-select-all btn ' + classNames.BUTTONCLASS + '">' +
                        this.options.selectAllText +
                        '</button>' +
                        '<button type="button" class="actions-btn bs-deselect-all btn ' + classNames.BUTTONCLASS + '">' +
                        this.options.deselectAllText +
                        '</button>' +
                        '</div>' +
                        '</div>';
                }

                if (this.multiple && this.options.doneButton) {
                    donebutton =
                        '<div class="bs-donebutton">' +
                        '<div class="btn-group btn-block">' +
                        '<button type="button" class="btn btn-sm ' + classNames.BUTTONCLASS + '">' +
                        this.options.doneButtonText +
                        '</button>' +
                        '</div>' +
                        '</div>';
                }

                drop =
                    '<div class="dropdown bootstrap-select' + showTick + inputGroup + '">' +
                    '<button type="button" class="' + this.options.styleBase + ' dropdown-toggle" ' + (this.options.display === 'static' ? 'data-display="static"' : '') + 'data-toggle="dropdown"' + autofocus + ' role="combobox" aria-owns="' + this.selectId + '" aria-haspopup="listbox" aria-expanded="false">' +
                    '<div class="filter-option">' +
                    '<div class="filter-option-inner">' +
                    '<div class="filter-option-inner-inner"></div>' +
                    '</div> ' +
                    '</div>' +
                    (
                        version.major === '4' ? ''
                            :
                            '<span class="bs-caret">' +
                            this.options.template.caret +
                            '</span>'
                    ) +
                    '</button>' +
                    '<div class="' + classNames.MENU + ' ' + (version.major === '4' ? '' : classNames.SHOW) + '">' +
                    header +
                    searchbox +
                    actionsbox +
                    '<div class="inner ' + classNames.SHOW + '" role="listbox" id="' + this.selectId + '" tabindex="-1" ' + multiselectable + '>' +
                    '<ul class="' + classNames.MENU + ' inner ' + (version.major === '4' ? classNames.SHOW : '') + '" role="presentation">' +
                    '</ul>' +
                    '</div>' +
                    donebutton +
                    '</div>' +
                    '</div>';

                return $(drop);
            },

            setPositionData: function () {
                this.selectpicker.view.canHighlight = [];
                this.selectpicker.view.size = 0;

                for (var i = 0; i < this.selectpicker.current.data.length; i++) {
                    var li = this.selectpicker.current.data[i],
                        canHighlight = true;

                    if (li.type === 'divider') {
                        canHighlight = false;
                        li.height = this.sizeInfo.dividerHeight;
                    } else if (li.type === 'optgroup-label') {
                        canHighlight = false;
                        li.height = this.sizeInfo.dropdownHeaderHeight;
                    } else {
                        li.height = this.sizeInfo.liHeight;
                    }

                    if (li.disabled) canHighlight = false;

                    this.selectpicker.view.canHighlight.push(canHighlight);

                    if (canHighlight) {
                        this.selectpicker.view.size++;
                        li.posinset = this.selectpicker.view.size;
                    }

                    li.position = (i === 0 ? 0 : this.selectpicker.current.data[i - 1].position) + li.height;
                }
            },

            isVirtual: function () {
                return (this.options.virtualScroll !== false) && (this.selectpicker.main.elements.length >= this.options.virtualScroll) || this.options.virtualScroll === true;
            },

            createView: function (isSearching, setSize, refresh) {
                var that = this,
                    scrollTop = 0,
                    active = [],
                    selected,
                    prevActive;

                this.selectpicker.isSearching = isSearching;
                this.selectpicker.current = isSearching ? this.selectpicker.search : this.selectpicker.main;

                this.setPositionData();

                if (setSize) {
                    if (refresh) {
                        scrollTop = this.$menuInner[0].scrollTop;
                    } else if (!that.multiple) {
                        var element = that.$element[0],
                            selectedIndex = (element.options[element.selectedIndex] || {}).liIndex;

                        if (typeof selectedIndex === 'number' && that.options.size !== false) {
                            var selectedData = that.selectpicker.main.data[selectedIndex],
                                position = selectedData && selectedData.position;

                            if (position) {
                                scrollTop = position - ((that.sizeInfo.menuInnerHeight + that.sizeInfo.liHeight) / 2);
                            }
                        }
                    }
                }

                scroll(scrollTop, true);

                this.$menuInner.off('scroll.createView').on('scroll.createView', function (e, updateValue) {
                    if (!that.noScroll) scroll(this.scrollTop, updateValue);
                    that.noScroll = false;
                });

                function scroll (scrollTop, init) {
                    var size = that.selectpicker.current.elements.length,
                        chunks = [],
                        chunkSize,
                        chunkCount,
                        firstChunk,
                        lastChunk,
                        currentChunk,
                        prevPositions,
                        positionIsDifferent,
                        previousElements,
                        menuIsDifferent = true,
                        isVirtual = that.isVirtual();

                    that.selectpicker.view.scrollTop = scrollTop;

                    chunkSize = Math.ceil(that.sizeInfo.menuInnerHeight / that.sizeInfo.liHeight * 1.5); // number of options in a chunk
                    chunkCount = Math.round(size / chunkSize) || 1; // number of chunks

                    for (var i = 0; i < chunkCount; i++) {
                        var endOfChunk = (i + 1) * chunkSize;

                        if (i === chunkCount - 1) {
                            endOfChunk = size;
                        }

                        chunks[i] = [
                            (i) * chunkSize + (!i ? 0 : 1),
                            endOfChunk
                        ];

                        if (!size) break;

                        if (currentChunk === undefined && scrollTop - 1 <= that.selectpicker.current.data[endOfChunk - 1].position - that.sizeInfo.menuInnerHeight) {
                            currentChunk = i;
                        }
                    }

                    if (currentChunk === undefined) currentChunk = 0;

                    prevPositions = [that.selectpicker.view.position0, that.selectpicker.view.position1];

                    // always display previous, current, and next chunks
                    firstChunk = Math.max(0, currentChunk - 1);
                    lastChunk = Math.min(chunkCount - 1, currentChunk + 1);

                    that.selectpicker.view.position0 = isVirtual === false ? 0 : (Math.max(0, chunks[firstChunk][0]) || 0);
                    that.selectpicker.view.position1 = isVirtual === false ? size : (Math.min(size, chunks[lastChunk][1]) || 0);

                    positionIsDifferent = prevPositions[0] !== that.selectpicker.view.position0 || prevPositions[1] !== that.selectpicker.view.position1;

                    if (that.activeIndex !== undefined) {
                        prevActive = that.selectpicker.main.elements[that.prevActiveIndex];
                        active = that.selectpicker.main.elements[that.activeIndex];
                        selected = that.selectpicker.main.elements[that.selectedIndex];

                        if (init) {
                            if (that.activeIndex !== that.selectedIndex) {
                                that.defocusItem(active);
                            }
                            that.activeIndex = undefined;
                        }

                        if (that.activeIndex && that.activeIndex !== that.selectedIndex) {
                            that.defocusItem(selected);
                        }
                    }

                    if (that.prevActiveIndex !== undefined && that.prevActiveIndex !== that.activeIndex && that.prevActiveIndex !== that.selectedIndex) {
                        that.defocusItem(prevActive);
                    }

                    if (init || positionIsDifferent) {
                        previousElements = that.selectpicker.view.visibleElements ? that.selectpicker.view.visibleElements.slice() : [];

                        if (isVirtual === false) {
                            that.selectpicker.view.visibleElements = that.selectpicker.current.elements;
                        } else {
                            that.selectpicker.view.visibleElements = that.selectpicker.current.elements.slice(that.selectpicker.view.position0, that.selectpicker.view.position1);
                        }

                        that.setOptionStatus();

                        // if searching, check to make sure the list has actually been updated before updating DOM
                        // this prevents unnecessary repaints
                        if (isSearching || (isVirtual === false && init)) menuIsDifferent = !isEqual(previousElements, that.selectpicker.view.visibleElements);

                        // if virtual scroll is disabled and not searching,
                        // menu should never need to be updated more than once
                        if ((init || isVirtual === true) && menuIsDifferent) {
                            var menuInner = that.$menuInner[0],
                                menuFragment = document.createDocumentFragment(),
                                emptyMenu = menuInner.firstChild.cloneNode(false),
                                marginTop,
                                marginBottom,
                                elements = that.selectpicker.view.visibleElements,
                                toSanitize = [];

                            // replace the existing UL with an empty one - this is faster than $.empty()
                            menuInner.replaceChild(emptyMenu, menuInner.firstChild);

                            for (var i = 0, visibleElementsLen = elements.length; i < visibleElementsLen; i++) {
                                var element = elements[i],
                                    elText,
                                    elementData;

                                if (that.options.sanitize) {
                                    elText = element.lastChild;

                                    if (elText) {
                                        elementData = that.selectpicker.current.data[i + that.selectpicker.view.position0];

                                        if (elementData && elementData.content && !elementData.sanitized) {
                                            toSanitize.push(elText);
                                            elementData.sanitized = true;
                                        }
                                    }
                                }

                                menuFragment.appendChild(element);
                            }

                            if (that.options.sanitize && toSanitize.length) {
                                sanitizeHtml(toSanitize, that.options.whiteList, that.options.sanitizeFn);
                            }

                            if (isVirtual === true) {
                                marginTop = (that.selectpicker.view.position0 === 0 ? 0 : that.selectpicker.current.data[that.selectpicker.view.position0 - 1].position);
                                marginBottom = (that.selectpicker.view.position1 > size - 1 ? 0 : that.selectpicker.current.data[size - 1].position - that.selectpicker.current.data[that.selectpicker.view.position1 - 1].position);

                                menuInner.firstChild.style.marginTop = marginTop + 'px';
                                menuInner.firstChild.style.marginBottom = marginBottom + 'px';
                            } else {
                                menuInner.firstChild.style.marginTop = 0;
                                menuInner.firstChild.style.marginBottom = 0;
                            }

                            menuInner.firstChild.appendChild(menuFragment);

                            // if an option is encountered that is wider than the current menu width, update the menu width accordingly
                            // switch to ResizeObserver with increased browser support
                            if (isVirtual === true && that.sizeInfo.hasScrollBar) {
                                var menuInnerInnerWidth = menuInner.firstChild.offsetWidth;

                                if (init && menuInnerInnerWidth < that.sizeInfo.menuInnerInnerWidth && that.sizeInfo.totalMenuWidth > that.sizeInfo.selectWidth) {
                                    menuInner.firstChild.style.minWidth = that.sizeInfo.menuInnerInnerWidth + 'px';
                                } else if (menuInnerInnerWidth > that.sizeInfo.menuInnerInnerWidth) {
                                    // set to 0 to get actual width of menu
                                    that.$menu[0].style.minWidth = 0;

                                    var actualMenuWidth = menuInner.firstChild.offsetWidth;

                                    if (actualMenuWidth > that.sizeInfo.menuInnerInnerWidth) {
                                        that.sizeInfo.menuInnerInnerWidth = actualMenuWidth;
                                        menuInner.firstChild.style.minWidth = that.sizeInfo.menuInnerInnerWidth + 'px';
                                    }

                                    // reset to default CSS styling
                                    that.$menu[0].style.minWidth = '';
                                }
                            }
                        }
                    }

                    that.prevActiveIndex = that.activeIndex;

                    if (!that.options.liveSearch) {
                        that.$menuInner.trigger('focus');
                    } else if (isSearching && init) {
                        var index = 0,
                            newActive;

                        if (!that.selectpicker.view.canHighlight[index]) {
                            index = 1 + that.selectpicker.view.canHighlight.slice(1).indexOf(true);
                        }

                        newActive = that.selectpicker.view.visibleElements[index];

                        that.defocusItem(that.selectpicker.view.currentActive);

                        that.activeIndex = (that.selectpicker.current.data[index] || {}).index;

                        that.focusItem(newActive);
                    }
                }

                $(window)
                    .off('resize' + EVENT_KEY + '.' + this.selectId + '.createView')
                    .on('resize' + EVENT_KEY + '.' + this.selectId + '.createView', function () {
                        var isActive = that.$newElement.hasClass(classNames.SHOW);

                        if (isActive) scroll(that.$menuInner[0].scrollTop);
                    });
            },

            focusItem: function (li, liData, noStyle) {
                if (li) {
                    liData = liData || this.selectpicker.main.data[this.activeIndex];
                    var a = li.firstChild;

                    if (a) {
                        a.setAttribute('aria-setsize', this.selectpicker.view.size);
                        a.setAttribute('aria-posinset', liData.posinset);

                        if (noStyle !== true) {
                            this.focusedParent.setAttribute('aria-activedescendant', a.id);
                            li.classList.add('active');
                            a.classList.add('active');
                        }
                    }
                }
            },

            defocusItem: function (li) {
                if (li) {
                    li.classList.remove('active');
                    if (li.firstChild) li.firstChild.classList.remove('active');
                }
            },

            setPlaceholder: function () {
                var updateIndex = false;

                if (this.options.title && !this.multiple) {
                    if (!this.selectpicker.view.titleOption) this.selectpicker.view.titleOption = document.createElement('option');

                    // this option doesn't create a new <li> element, but does add a new option at the start,
                    // so startIndex should increase to prevent having to check every option for the bs-title-option class
                    updateIndex = true;

                    var element = this.$element[0],
                        isSelected = false,
                        titleNotAppended = !this.selectpicker.view.titleOption.parentNode;

                    if (titleNotAppended) {
                        // Use native JS to prepend option (faster)
                        this.selectpicker.view.titleOption.className = 'bs-title-option';
                        this.selectpicker.view.titleOption.value = '';

                        // Check if selected or data-selected attribute is already set on an option. If not, select the titleOption option.
                        // the selected item may have been changed by user or programmatically before the bootstrap select plugin runs,
                        // if so, the select will have the data-selected attribute
                        var $opt = $(element.options[element.selectedIndex]);
                        isSelected = $opt.attr('selected') === undefined && this.$element.data('selected') === undefined;
                    }

                    if (titleNotAppended || this.selectpicker.view.titleOption.index !== 0) {
                        element.insertBefore(this.selectpicker.view.titleOption, element.firstChild);
                    }

                    // Set selected *after* appending to select,
                    // otherwise the option doesn't get selected in IE
                    // set using selectedIndex, as setting the selected attr to true here doesn't work in IE11
                    if (isSelected) element.selectedIndex = 0;
                }

                return updateIndex;
            },

            buildData: function () {
                var optionSelector = ':not([hidden]):not([data-hidden="true"])',
                    mainData = [],
                    optID = 0,
                    startIndex = this.setPlaceholder() ? 1 : 0; // append the titleOption if necessary and skip the first option in the loop

                if (this.options.hideDisabled) optionSelector += ':not(:disabled)';

                var selectOptions = this.$element[0].querySelectorAll('select > *' + optionSelector);

                function addDivider (config) {
                    var previousData = mainData[mainData.length - 1];

                    // ensure optgroup doesn't create back-to-back dividers
                    if (
                        previousData &&
                        previousData.type === 'divider' &&
                        (previousData.optID || config.optID)
                    ) {
                        return;
                    }

                    config = config || {};
                    config.type = 'divider';

                    mainData.push(config);
                }

                function addOption (option, config) {
                    config = config || {};

                    config.divider = option.getAttribute('data-divider') === 'true';

                    if (config.divider) {
                        addDivider({
                            optID: config.optID
                        });
                    } else {
                        var liIndex = mainData.length,
                            cssText = option.style.cssText,
                            inlineStyle = cssText ? htmlEscape(cssText) : '',
                            optionClass = (option.className || '') + (config.optgroupClass || '');

                        if (config.optID) optionClass = 'opt ' + optionClass;

                        config.optionClass = optionClass.trim();
                        config.inlineStyle = inlineStyle;
                        config.text = option.textContent;

                        config.content = option.getAttribute('data-content');
                        config.tokens = option.getAttribute('data-tokens');
                        config.subtext = option.getAttribute('data-subtext');
                        config.icon = option.getAttribute('data-icon');

                        option.liIndex = liIndex;

                        config.display = config.content || config.text;
                        config.type = 'option';
                        config.index = liIndex;
                        config.option = option;
                        config.selected = !!option.selected;
                        config.disabled = config.disabled || !!option.disabled;

                        mainData.push(config);
                    }
                }

                function addOptgroup (index, selectOptions) {
                    var optgroup = selectOptions[index],
                        previous = selectOptions[index - 1],
                        next = selectOptions[index + 1],
                        options = optgroup.querySelectorAll('option' + optionSelector);

                    if (!options.length) return;

                    var config = {
                            display: htmlEscape(optgroup.label),
                            subtext: optgroup.getAttribute('data-subtext'),
                            icon: optgroup.getAttribute('data-icon'),
                            type: 'optgroup-label',
                            optgroupClass: ' ' + (optgroup.className || '')
                        },
                        headerIndex,
                        lastIndex;

                    optID++;

                    if (previous) {
                        addDivider({ optID: optID });
                    }

                    config.optID = optID;

                    mainData.push(config);

                    for (var j = 0, len = options.length; j < len; j++) {
                        var option = options[j];

                        if (j === 0) {
                            headerIndex = mainData.length - 1;
                            lastIndex = headerIndex + len;
                        }

                        addOption(option, {
                            headerIndex: headerIndex,
                            lastIndex: lastIndex,
                            optID: config.optID,
                            optgroupClass: config.optgroupClass,
                            disabled: optgroup.disabled
                        });
                    }

                    if (next) {
                        addDivider({ optID: optID });
                    }
                }

                for (var len = selectOptions.length; startIndex < len; startIndex++) {
                    var item = selectOptions[startIndex];

                    if (item.tagName !== 'OPTGROUP') {
                        addOption(item, {});
                    } else {
                        addOptgroup(startIndex, selectOptions);
                    }
                }

                this.selectpicker.main.data = this.selectpicker.current.data = mainData;
            },

            buildList: function () {
                var that = this,
                    selectData = this.selectpicker.main.data,
                    mainElements = [],
                    widestOptionLength = 0;

                if ((that.options.showTick || that.multiple) && !elementTemplates.checkMark.parentNode) {
                    elementTemplates.checkMark.className = this.options.iconBase + ' ' + that.options.tickIcon + ' check-mark';
                    elementTemplates.a.appendChild(elementTemplates.checkMark);
                }

                function buildElement (item) {
                    var liElement,
                        combinedLength = 0;

                    switch (item.type) {
                        case 'divider':
                            liElement = generateOption.li(
                                false,
                                classNames.DIVIDER,
                                (item.optID ? item.optID + 'div' : undefined)
                            );

                            break;

                        case 'option':
                            liElement = generateOption.li(
                                generateOption.a(
                                    generateOption.text.call(that, item),
                                    item.optionClass,
                                    item.inlineStyle
                                ),
                                '',
                                item.optID
                            );

                            if (liElement.firstChild) {
                                liElement.firstChild.id = that.selectId + '-' + item.index;
                            }

                            break;

                        case 'optgroup-label':
                            liElement = generateOption.li(
                                generateOption.label.call(that, item),
                                'dropdown-header' + item.optgroupClass,
                                item.optID
                            );

                            break;
                    }

                    mainElements.push(liElement);

                    // count the number of characters in the option - not perfect, but should work in most cases
                    if (item.display) combinedLength += item.display.length;
                    if (item.subtext) combinedLength += item.subtext.length;
                    // if there is an icon, ensure this option's width is checked
                    if (item.icon) combinedLength += 1;

                    if (combinedLength > widestOptionLength) {
                        widestOptionLength = combinedLength;

                        // guess which option is the widest
                        // use this when calculating menu width
                        // not perfect, but it's fast, and the width will be updating accordingly when scrolling
                        that.selectpicker.view.widestOption = mainElements[mainElements.length - 1];
                    }
                }

                for (var len = selectData.length, i = 0; i < len; i++) {
                    var item = selectData[i];

                    buildElement(item);
                }

                this.selectpicker.main.elements = this.selectpicker.current.elements = mainElements;
            },

            findLis: function () {
                return this.$menuInner.find('.inner > li');
            },

            render: function () {
                var that = this,
                    element = this.$element[0],
                    // ensure titleOption is appended and selected (if necessary) before getting selectedOptions
                    placeholderSelected = this.setPlaceholder() && element.selectedIndex === 0,
                    selectedOptions = getSelectedOptions(element, this.options.hideDisabled),
                    selectedCount = selectedOptions.length,
                    button = this.$button[0],
                    buttonInner = button.querySelector('.filter-option-inner-inner'),
                    multipleSeparator = document.createTextNode(this.options.multipleSeparator),
                    titleFragment = elementTemplates.fragment.cloneNode(false),
                    showCount,
                    countMax,
                    hasContent = false;

                button.classList.toggle('bs-placeholder', that.multiple ? !selectedCount : !getSelectValues(element, selectedOptions));

                this.tabIndex();

                if (this.options.selectedTextFormat === 'static') {
                    titleFragment = generateOption.text.call(this, { text: this.options.title }, true);
                } else {
                    showCount = this.multiple && this.options.selectedTextFormat.indexOf('count') !== -1 && selectedCount > 1;

                    // determine if the number of selected options will be shown (showCount === true)
                    if (showCount) {
                        countMax = this.options.selectedTextFormat.split('>');
                        showCount = (countMax.length > 1 && selectedCount > countMax[1]) || (countMax.length === 1 && selectedCount >= 2);
                    }

                    // only loop through all selected options if the count won't be shown
                    if (showCount === false) {
                        if (!placeholderSelected) {
                            for (var selectedIndex = 0; selectedIndex < selectedCount; selectedIndex++) {
                                if (selectedIndex < 50) {
                                    var option = selectedOptions[selectedIndex],
                                        thisData = this.selectpicker.main.data[option.liIndex],
                                        titleOptions = {};

                                    if (this.multiple && selectedIndex > 0) {
                                        titleFragment.appendChild(multipleSeparator.cloneNode(false));
                                    }

                                    if (option.title) {
                                        titleOptions.text = option.title;
                                    } else if (thisData) {
                                        if (thisData.content && that.options.showContent) {
                                            titleOptions.content = thisData.content.toString();
                                            hasContent = true;
                                        } else {
                                            if (that.options.showIcon) {
                                                titleOptions.icon = thisData.icon;
                                            }
                                            if (that.options.showSubtext && !that.multiple && thisData.subtext) titleOptions.subtext = ' ' + thisData.subtext;
                                            titleOptions.text = option.textContent.trim();
                                        }
                                    }

                                    titleFragment.appendChild(generateOption.text.call(this, titleOptions, true));
                                } else {
                                    break;
                                }
                            }

                            // add ellipsis
                            if (selectedCount > 49) {
                                titleFragment.appendChild(document.createTextNode('...'));
                            }
                        }
                    } else {
                        var optionSelector = ':not([hidden]):not([data-hidden="true"]):not([data-divider="true"])';
                        if (this.options.hideDisabled) optionSelector += ':not(:disabled)';

                        // If this is a multiselect, and selectedTextFormat is count, then show 1 of 2 selected, etc.
                        var totalCount = this.$element[0].querySelectorAll('select > option' + optionSelector + ', optgroup' + optionSelector + ' option' + optionSelector).length,
                            tr8nText = (typeof this.options.countSelectedText === 'function') ? this.options.countSelectedText(selectedCount, totalCount) : this.options.countSelectedText;

                        titleFragment = generateOption.text.call(this, {
                            text: tr8nText.replace('{0}', selectedCount.toString()).replace('{1}', totalCount.toString())
                        }, true);
                    }
                }

                if (this.options.title == undefined) {
                    // use .attr to ensure undefined is returned if title attribute is not set
                    this.options.title = this.$element.attr('title');
                }

                // If the select doesn't have a title, then use the default, or if nothing is set at all, use noneSelectedText
                if (!titleFragment.childNodes.length) {
                    titleFragment = generateOption.text.call(this, {
                        text: typeof this.options.title !== 'undefined' ? this.options.title : this.options.noneSelectedText
                    }, true);
                }

                // strip all HTML tags and trim the result, then unescape any escaped tags
                button.title = titleFragment.textContent.replace(/<[^>]*>?/g, '').trim();

                if (this.options.sanitize && hasContent) {
                    sanitizeHtml([titleFragment], that.options.whiteList, that.options.sanitizeFn);
                }

                buttonInner.innerHTML = '';
                buttonInner.appendChild(titleFragment);

                if (version.major < 4 && this.$newElement[0].classList.contains('bs3-has-addon')) {
                    var filterExpand = button.querySelector('.filter-expand'),
                        clone = buttonInner.cloneNode(true);

                    clone.className = 'filter-expand';

                    if (filterExpand) {
                        button.replaceChild(clone, filterExpand);
                    } else {
                        button.appendChild(clone);
                    }
                }

                this.$element.trigger('rendered' + EVENT_KEY);
            },

            /**
             * @param [style]
             * @param [status]
             */
            setStyle: function (newStyle, status) {
                var button = this.$button[0],
                    newElement = this.$newElement[0],
                    style = this.options.style.trim(),
                    buttonClass;

                if (this.$element.attr('class')) {
                    this.$newElement.addClass(this.$element.attr('class').replace(/selectpicker|mobile-device|bs-select-hidden|validate\[.*\]/gi, ''));
                }

                if (version.major < 4) {
                    newElement.classList.add('bs3');

                    if (newElement.parentNode.classList.contains('input-group') &&
                        (newElement.previousElementSibling || newElement.nextElementSibling) &&
                        (newElement.previousElementSibling || newElement.nextElementSibling).classList.contains('input-group-addon')
                    ) {
                        newElement.classList.add('bs3-has-addon');
                    }
                }

                if (newStyle) {
                    buttonClass = newStyle.trim();
                } else {
                    buttonClass = style;
                }

                if (status == 'add') {
                    if (buttonClass) button.classList.add.apply(button.classList, buttonClass.split(' '));
                } else if (status == 'remove') {
                    if (buttonClass) button.classList.remove.apply(button.classList, buttonClass.split(' '));
                } else {
                    if (style) button.classList.remove.apply(button.classList, style.split(' '));
                    if (buttonClass) button.classList.add.apply(button.classList, buttonClass.split(' '));
                }
            },

            liHeight: function (refresh) {
                if (!refresh && (this.options.size === false || Object.keys(this.sizeInfo).length)) return;

                var newElement = document.createElement('div'),
                    menu = document.createElement('div'),
                    menuInner = document.createElement('div'),
                    menuInnerInner = document.createElement('ul'),
                    divider = document.createElement('li'),
                    dropdownHeader = document.createElement('li'),
                    li = document.createElement('li'),
                    a = document.createElement('a'),
                    text = document.createElement('span'),
                    header = this.options.header && this.$menu.find('.' + classNames.POPOVERHEADER).length > 0 ? this.$menu.find('.' + classNames.POPOVERHEADER)[0].cloneNode(true) : null,
                    search = this.options.liveSearch ? document.createElement('div') : null,
                    actions = this.options.actionsBox && this.multiple && this.$menu.find('.bs-actionsbox').length > 0 ? this.$menu.find('.bs-actionsbox')[0].cloneNode(true) : null,
                    doneButton = this.options.doneButton && this.multiple && this.$menu.find('.bs-donebutton').length > 0 ? this.$menu.find('.bs-donebutton')[0].cloneNode(true) : null,
                    firstOption = this.$element.find('option')[0];

                this.sizeInfo.selectWidth = this.$newElement[0].offsetWidth;

                text.className = 'text';
                a.className = 'dropdown-item ' + (firstOption ? firstOption.className : '');
                newElement.className = this.$menu[0].parentNode.className + ' ' + classNames.SHOW;
                newElement.style.width = 0; // ensure button width doesn't affect natural width of menu when calculating
                if (this.options.width === 'auto') menu.style.minWidth = 0;
                menu.className = classNames.MENU + ' ' + classNames.SHOW;
                menuInner.className = 'inner ' + classNames.SHOW;
                menuInnerInner.className = classNames.MENU + ' inner ' + (version.major === '4' ? classNames.SHOW : '');
                divider.className = classNames.DIVIDER;
                dropdownHeader.className = 'dropdown-header';

                text.appendChild(document.createTextNode('\u200b'));
                a.appendChild(text);
                li.appendChild(a);
                dropdownHeader.appendChild(text.cloneNode(true));

                if (this.selectpicker.view.widestOption) {
                    menuInnerInner.appendChild(this.selectpicker.view.widestOption.cloneNode(true));
                }

                menuInnerInner.appendChild(li);
                menuInnerInner.appendChild(divider);
                menuInnerInner.appendChild(dropdownHeader);
                if (header) menu.appendChild(header);
                if (search) {
                    var input = document.createElement('input');
                    search.className = 'bs-searchbox';
                    input.className = 'form-control';
                    search.appendChild(input);
                    menu.appendChild(search);
                }
                if (actions) menu.appendChild(actions);
                menuInner.appendChild(menuInnerInner);
                menu.appendChild(menuInner);
                if (doneButton) menu.appendChild(doneButton);
                newElement.appendChild(menu);

                document.body.appendChild(newElement);

                var liHeight = li.offsetHeight,
                    dropdownHeaderHeight = dropdownHeader ? dropdownHeader.offsetHeight : 0,
                    headerHeight = header ? header.offsetHeight : 0,
                    searchHeight = search ? search.offsetHeight : 0,
                    actionsHeight = actions ? actions.offsetHeight : 0,
                    doneButtonHeight = doneButton ? doneButton.offsetHeight : 0,
                    dividerHeight = $(divider).outerHeight(true),
                    // fall back to jQuery if getComputedStyle is not supported
                    menuStyle = window.getComputedStyle ? window.getComputedStyle(menu) : false,
                    menuWidth = menu.offsetWidth,
                    $menu = menuStyle ? null : $(menu),
                    menuPadding = {
                        vert: toInteger(menuStyle ? menuStyle.paddingTop : $menu.css('paddingTop')) +
                            toInteger(menuStyle ? menuStyle.paddingBottom : $menu.css('paddingBottom')) +
                            toInteger(menuStyle ? menuStyle.borderTopWidth : $menu.css('borderTopWidth')) +
                            toInteger(menuStyle ? menuStyle.borderBottomWidth : $menu.css('borderBottomWidth')),
                        horiz: toInteger(menuStyle ? menuStyle.paddingLeft : $menu.css('paddingLeft')) +
                            toInteger(menuStyle ? menuStyle.paddingRight : $menu.css('paddingRight')) +
                            toInteger(menuStyle ? menuStyle.borderLeftWidth : $menu.css('borderLeftWidth')) +
                            toInteger(menuStyle ? menuStyle.borderRightWidth : $menu.css('borderRightWidth'))
                    },
                    menuExtras = {
                        vert: menuPadding.vert +
                            toInteger(menuStyle ? menuStyle.marginTop : $menu.css('marginTop')) +
                            toInteger(menuStyle ? menuStyle.marginBottom : $menu.css('marginBottom')) + 2,
                        horiz: menuPadding.horiz +
                            toInteger(menuStyle ? menuStyle.marginLeft : $menu.css('marginLeft')) +
                            toInteger(menuStyle ? menuStyle.marginRight : $menu.css('marginRight')) + 2
                    },
                    scrollBarWidth;

                menuInner.style.overflowY = 'scroll';

                scrollBarWidth = menu.offsetWidth - menuWidth;

                document.body.removeChild(newElement);

                this.sizeInfo.liHeight = liHeight;
                this.sizeInfo.dropdownHeaderHeight = dropdownHeaderHeight;
                this.sizeInfo.headerHeight = headerHeight;
                this.sizeInfo.searchHeight = searchHeight;
                this.sizeInfo.actionsHeight = actionsHeight;
                this.sizeInfo.doneButtonHeight = doneButtonHeight;
                this.sizeInfo.dividerHeight = dividerHeight;
                this.sizeInfo.menuPadding = menuPadding;
                this.sizeInfo.menuExtras = menuExtras;
                this.sizeInfo.menuWidth = menuWidth;
                this.sizeInfo.menuInnerInnerWidth = menuWidth - menuPadding.horiz;
                this.sizeInfo.totalMenuWidth = this.sizeInfo.menuWidth;
                this.sizeInfo.scrollBarWidth = scrollBarWidth;
                this.sizeInfo.selectHeight = this.$newElement[0].offsetHeight;

                this.setPositionData();
            },

            getSelectPosition: function () {
                var that = this,
                    $window = $(window),
                    pos = that.$newElement.offset(),
                    $container = $(that.options.container),
                    containerPos;

                if (that.options.container && $container.length && !$container.is('body')) {
                    containerPos = $container.offset();
                    containerPos.top += parseInt($container.css('borderTopWidth'));
                    containerPos.left += parseInt($container.css('borderLeftWidth'));
                } else {
                    containerPos = { top: 0, left: 0 };
                }

                var winPad = that.options.windowPadding;

                this.sizeInfo.selectOffsetTop = pos.top - containerPos.top - $window.scrollTop();
                this.sizeInfo.selectOffsetBot = $window.height() - this.sizeInfo.selectOffsetTop - this.sizeInfo.selectHeight - containerPos.top - winPad[2];
                this.sizeInfo.selectOffsetLeft = pos.left - containerPos.left - $window.scrollLeft();
                this.sizeInfo.selectOffsetRight = $window.width() - this.sizeInfo.selectOffsetLeft - this.sizeInfo.selectWidth - containerPos.left - winPad[1];
                this.sizeInfo.selectOffsetTop -= winPad[0];
                this.sizeInfo.selectOffsetLeft -= winPad[3];
            },

            setMenuSize: function (isAuto) {
                this.getSelectPosition();

                var selectWidth = this.sizeInfo.selectWidth,
                    liHeight = this.sizeInfo.liHeight,
                    headerHeight = this.sizeInfo.headerHeight,
                    searchHeight = this.sizeInfo.searchHeight,
                    actionsHeight = this.sizeInfo.actionsHeight,
                    doneButtonHeight = this.sizeInfo.doneButtonHeight,
                    divHeight = this.sizeInfo.dividerHeight,
                    menuPadding = this.sizeInfo.menuPadding,
                    menuInnerHeight,
                    menuHeight,
                    divLength = 0,
                    minHeight,
                    _minHeight,
                    maxHeight,
                    menuInnerMinHeight,
                    estimate,
                    isDropup;

                if (this.options.dropupAuto) {
                    // Get the estimated height of the menu without scrollbars.
                    // This is useful for smaller menus, where there might be plenty of room
                    // below the button without setting dropup, but we can't know
                    // the exact height of the menu until createView is called later
                    estimate = liHeight * this.selectpicker.current.elements.length + menuPadding.vert;

                    isDropup = this.sizeInfo.selectOffsetTop - this.sizeInfo.selectOffsetBot > this.sizeInfo.menuExtras.vert && estimate + this.sizeInfo.menuExtras.vert + 50 > this.sizeInfo.selectOffsetBot;

                    // ensure dropup doesn't change while searching (so menu doesn't bounce back and forth)
                    if (this.selectpicker.isSearching === true) {
                        isDropup = this.selectpicker.dropup;
                    }

                    this.$newElement.toggleClass(classNames.DROPUP, isDropup);
                    this.selectpicker.dropup = isDropup;
                }

                if (this.options.size === 'auto') {
                    _minHeight = this.selectpicker.current.elements.length > 3 ? this.sizeInfo.liHeight * 3 + this.sizeInfo.menuExtras.vert - 2 : 0;
                    menuHeight = this.sizeInfo.selectOffsetBot - this.sizeInfo.menuExtras.vert;
                    minHeight = _minHeight + headerHeight + searchHeight + actionsHeight + doneButtonHeight;
                    menuInnerMinHeight = Math.max(_minHeight - menuPadding.vert, 0);

                    if (this.$newElement.hasClass(classNames.DROPUP)) {
                        menuHeight = this.sizeInfo.selectOffsetTop - this.sizeInfo.menuExtras.vert;
                    }

                    maxHeight = menuHeight;
                    menuInnerHeight = menuHeight - headerHeight - searchHeight - actionsHeight - doneButtonHeight - menuPadding.vert;
                } else if (this.options.size && this.options.size != 'auto' && this.selectpicker.current.elements.length > this.options.size) {
                    for (var i = 0; i < this.options.size; i++) {
                        if (this.selectpicker.current.data[i].type === 'divider') divLength++;
                    }

                    menuHeight = liHeight * this.options.size + divLength * divHeight + menuPadding.vert;
                    menuInnerHeight = menuHeight - menuPadding.vert;
                    maxHeight = menuHeight + headerHeight + searchHeight + actionsHeight + doneButtonHeight;
                    minHeight = menuInnerMinHeight = '';
                }

                this.$menu.css({
                    'max-height': maxHeight + 'px',
                    'overflow': 'hidden',
                    'min-height': minHeight + 'px'
                });

                this.$menuInner.css({
                    'max-height': menuInnerHeight + 'px',
                    'overflow-y': 'auto',
                    'min-height': menuInnerMinHeight + 'px'
                });

                // ensure menuInnerHeight is always a positive number to prevent issues calculating chunkSize in createView
                this.sizeInfo.menuInnerHeight = Math.max(menuInnerHeight, 1);

                if (this.selectpicker.current.data.length && this.selectpicker.current.data[this.selectpicker.current.data.length - 1].position > this.sizeInfo.menuInnerHeight) {
                    this.sizeInfo.hasScrollBar = true;
                    this.sizeInfo.totalMenuWidth = this.sizeInfo.menuWidth + this.sizeInfo.scrollBarWidth;
                }

                if (this.options.dropdownAlignRight === 'auto') {
                    this.$menu.toggleClass(classNames.MENURIGHT, this.sizeInfo.selectOffsetLeft > this.sizeInfo.selectOffsetRight && this.sizeInfo.selectOffsetRight < (this.sizeInfo.totalMenuWidth - selectWidth));
                }

                if (this.dropdown && this.dropdown._popper) this.dropdown._popper.update();
            },

            setSize: function (refresh) {
                this.liHeight(refresh);

                if (this.options.header) this.$menu.css('padding-top', 0);

                if (this.options.size !== false) {
                    var that = this,
                        $window = $(window);

                    this.setMenuSize();

                    if (this.options.liveSearch) {
                        this.$searchbox
                            .off('input.setMenuSize propertychange.setMenuSize')
                            .on('input.setMenuSize propertychange.setMenuSize', function () {
                                return that.setMenuSize();
                            });
                    }

                    if (this.options.size === 'auto') {
                        $window
                            .off('resize' + EVENT_KEY + '.' + this.selectId + '.setMenuSize' + ' scroll' + EVENT_KEY + '.' + this.selectId + '.setMenuSize')
                            .on('resize' + EVENT_KEY + '.' + this.selectId + '.setMenuSize' + ' scroll' + EVENT_KEY + '.' + this.selectId + '.setMenuSize', function () {
                                return that.setMenuSize();
                            });
                    } else if (this.options.size && this.options.size != 'auto' && this.selectpicker.current.elements.length > this.options.size) {
                        $window.off('resize' + EVENT_KEY + '.' + this.selectId + '.setMenuSize' + ' scroll' + EVENT_KEY + '.' + this.selectId + '.setMenuSize');
                    }
                }

                this.createView(false, true, refresh);
            },

            setWidth: function () {
                var that = this;

                if (this.options.width === 'auto') {
                    requestAnimationFrame(function () {
                        that.$menu.css('min-width', '0');

                        that.$element.on('loaded' + EVENT_KEY, function () {
                            that.liHeight();
                            that.setMenuSize();

                            // Get correct width if element is hidden
                            var $selectClone = that.$newElement.clone().appendTo('body'),
                                btnWidth = $selectClone.css('width', 'auto').children('button').outerWidth();

                            $selectClone.remove();

                            // Set width to whatever's larger, button title or longest option
                            that.sizeInfo.selectWidth = Math.max(that.sizeInfo.totalMenuWidth, btnWidth);
                            that.$newElement.css('width', that.sizeInfo.selectWidth + 'px');
                        });
                    });
                } else if (this.options.width === 'fit') {
                    // Remove inline min-width so width can be changed from 'auto'
                    this.$menu.css('min-width', '');
                    this.$newElement.css('width', '').addClass('fit-width');
                } else if (this.options.width) {
                    // Remove inline min-width so width can be changed from 'auto'
                    this.$menu.css('min-width', '');
                    this.$newElement.css('width', this.options.width);
                } else {
                    // Remove inline min-width/width so width can be changed
                    this.$menu.css('min-width', '');
                    this.$newElement.css('width', '');
                }
                // Remove fit-width class if width is changed programmatically
                if (this.$newElement.hasClass('fit-width') && this.options.width !== 'fit') {
                    this.$newElement[0].classList.remove('fit-width');
                }
            },

            selectPosition: function () {
                this.$bsContainer = $('<div class="bs-container" />');

                var that = this,
                    $container = $(this.options.container),
                    pos,
                    containerPos,
                    actualHeight,
                    getPlacement = function ($element) {
                        var containerPosition = {},
                            // fall back to dropdown's default display setting if display is not manually set
                            display = that.options.display || (
                                // Bootstrap 3 doesn't have $.fn.dropdown.Constructor.Default
                                $.fn.dropdown.Constructor.Default ? $.fn.dropdown.Constructor.Default.display
                                    : false
                            );

                        that.$bsContainer.addClass($element.attr('class').replace(/form-control|fit-width/gi, '')).toggleClass(classNames.DROPUP, $element.hasClass(classNames.DROPUP));
                        pos = $element.offset();

                        if (!$container.is('body')) {
                            containerPos = $container.offset();
                            containerPos.top += parseInt($container.css('borderTopWidth')) - $container.scrollTop();
                            containerPos.left += parseInt($container.css('borderLeftWidth')) - $container.scrollLeft();
                        } else {
                            containerPos = { top: 0, left: 0 };
                        }

                        actualHeight = $element.hasClass(classNames.DROPUP) ? 0 : $element[0].offsetHeight;

                        // Bootstrap 4+ uses Popper for menu positioning
                        if (version.major < 4 || display === 'static') {
                            containerPosition.top = pos.top - containerPos.top + actualHeight;
                            containerPosition.left = pos.left - containerPos.left;
                        }

                        containerPosition.width = $element[0].offsetWidth;

                        that.$bsContainer.css(containerPosition);
                    };

                this.$button.on('click.bs.dropdown.data-api', function () {
                    if (that.isDisabled()) {
                        return;
                    }

                    getPlacement(that.$newElement);

                    that.$bsContainer
                        .appendTo(that.options.container)
                        .toggleClass(classNames.SHOW, !that.$button.hasClass(classNames.SHOW))
                        .append(that.$menu);
                });

                $(window)
                    .off('resize' + EVENT_KEY + '.' + this.selectId + ' scroll' + EVENT_KEY + '.' + this.selectId)
                    .on('resize' + EVENT_KEY + '.' + this.selectId + ' scroll' + EVENT_KEY + '.' + this.selectId, function () {
                        var isActive = that.$newElement.hasClass(classNames.SHOW);

                        if (isActive) getPlacement(that.$newElement);
                    });

                this.$element.on('hide' + EVENT_KEY, function () {
                    that.$menu.data('height', that.$menu.height());
                    that.$bsContainer.detach();
                });
            },

            setOptionStatus: function (selectedOnly) {
                var that = this;

                that.noScroll = false;

                if (that.selectpicker.view.visibleElements && that.selectpicker.view.visibleElements.length) {
                    for (var i = 0; i < that.selectpicker.view.visibleElements.length; i++) {
                        var liData = that.selectpicker.current.data[i + that.selectpicker.view.position0],
                            option = liData.option;

                        if (option) {
                            if (selectedOnly !== true) {
                                that.setDisabled(
                                    liData.index,
                                    liData.disabled
                                );
                            }

                            that.setSelected(
                                liData.index,
                                option.selected
                            );
                        }
                    }
                }
            },

            /**
             * @param {number} index - the index of the option that is being changed
             * @param {boolean} selected - true if the option is being selected, false if being deselected
             */
            setSelected: function (index, selected) {
                var li = this.selectpicker.main.elements[index],
                    liData = this.selectpicker.main.data[index],
                    activeIndexIsSet = this.activeIndex !== undefined,
                    thisIsActive = this.activeIndex === index,
                    prevActive,
                    a,
                    // if current option is already active
                    // OR
                    // if the current option is being selected, it's NOT multiple, and
                    // activeIndex is undefined:
                    //  - when the menu is first being opened, OR
                    //  - after a search has been performed, OR
                    //  - when retainActive is false when selecting a new option (i.e. index of the newly selected option is not the same as the current activeIndex)
                    keepActive = thisIsActive || (selected && !this.multiple && !activeIndexIsSet);

                liData.selected = selected;

                a = li.firstChild;

                if (selected) {
                    this.selectedIndex = index;
                }

                li.classList.toggle('selected', selected);

                if (keepActive) {
                    this.focusItem(li, liData);
                    this.selectpicker.view.currentActive = li;
                    this.activeIndex = index;
                } else {
                    this.defocusItem(li);
                }

                if (a) {
                    a.classList.toggle('selected', selected);

                    if (selected) {
                        a.setAttribute('aria-selected', true);
                    } else {
                        if (this.multiple) {
                            a.setAttribute('aria-selected', false);
                        } else {
                            a.removeAttribute('aria-selected');
                        }
                    }
                }

                if (!keepActive && !activeIndexIsSet && selected && this.prevActiveIndex !== undefined) {
                    prevActive = this.selectpicker.main.elements[this.prevActiveIndex];

                    this.defocusItem(prevActive);
                }
            },

            /**
             * @param {number} index - the index of the option that is being disabled
             * @param {boolean} disabled - true if the option is being disabled, false if being enabled
             */
            setDisabled: function (index, disabled) {
                var li = this.selectpicker.main.elements[index],
                    a;

                this.selectpicker.main.data[index].disabled = disabled;

                a = li.firstChild;

                li.classList.toggle(classNames.DISABLED, disabled);

                if (a) {
                    if (version.major === '4') a.classList.toggle(classNames.DISABLED, disabled);

                    if (disabled) {
                        a.setAttribute('aria-disabled', disabled);
                        a.setAttribute('tabindex', -1);
                    } else {
                        a.removeAttribute('aria-disabled');
                        a.setAttribute('tabindex', 0);
                    }
                }
            },

            isDisabled: function () {
                return this.$element[0].disabled;
            },

            checkDisabled: function () {
                if (this.isDisabled()) {
                    this.$newElement[0].classList.add(classNames.DISABLED);
                    this.$button.addClass(classNames.DISABLED).attr('tabindex', -1).attr('aria-disabled', true);
                } else {
                    if (this.$button[0].classList.contains(classNames.DISABLED)) {
                        this.$newElement[0].classList.remove(classNames.DISABLED);
                        this.$button.removeClass(classNames.DISABLED).attr('aria-disabled', false);
                    }

                    if (this.$button.attr('tabindex') == -1 && !this.$element.data('tabindex')) {
                        this.$button.removeAttr('tabindex');
                    }
                }
            },

            tabIndex: function () {
                if (this.$element.data('tabindex') !== this.$element.attr('tabindex') &&
                    (this.$element.attr('tabindex') !== -98 && this.$element.attr('tabindex') !== '-98')) {
                    this.$element.data('tabindex', this.$element.attr('tabindex'));
                    this.$button.attr('tabindex', this.$element.data('tabindex'));
                }

                this.$element.attr('tabindex', -98);
            },

            clickListener: function () {
                var that = this,
                    $document = $(document);

                $document.data('spaceSelect', false);

                this.$button.on('keyup', function (e) {
                    if (/(32)/.test(e.keyCode.toString(10)) && $document.data('spaceSelect')) {
                        e.preventDefault();
                        $document.data('spaceSelect', false);
                    }
                });

                this.$newElement.on('show.bs.dropdown', function () {
                    if (version.major > 3 && !that.dropdown) {
                        that.dropdown = that.$button.data('bs.dropdown');
                        that.dropdown._menu = that.$menu[0];
                    }
                });

                this.$button.on('click.bs.dropdown.data-api', function () {
                    if (!that.$newElement.hasClass(classNames.SHOW)) {
                        that.setSize();
                    }
                });

                function setFocus () {
                    if (that.options.liveSearch) {
                        that.$searchbox.trigger('focus');
                    } else {
                        that.$menuInner.trigger('focus');
                    }
                }

                function checkPopperExists () {
                    if (that.dropdown && that.dropdown._popper && that.dropdown._popper.state.isCreated) {
                        setFocus();
                    } else {
                        requestAnimationFrame(checkPopperExists);
                    }
                }

                this.$element.on('shown' + EVENT_KEY, function () {
                    if (that.$menuInner[0].scrollTop !== that.selectpicker.view.scrollTop) {
                        that.$menuInner[0].scrollTop = that.selectpicker.view.scrollTop;
                    }

                    if (version.major > 3) {
                        requestAnimationFrame(checkPopperExists);
                    } else {
                        setFocus();
                    }
                });

                // ensure posinset and setsize are correct before selecting an option via a click
                this.$menuInner.on('mouseenter', 'li a', function (e) {
                    var hoverLi = this.parentElement,
                        position0 = that.isVirtual() ? that.selectpicker.view.position0 : 0,
                        index = Array.prototype.indexOf.call(hoverLi.parentElement.children, hoverLi),
                        hoverData = that.selectpicker.current.data[index + position0];

                    that.focusItem(hoverLi, hoverData, true);
                });

                this.$menuInner.on('click', 'li a', function (e, retainActive) {
                    var $this = $(this),
                        element = that.$element[0],
                        position0 = that.isVirtual() ? that.selectpicker.view.position0 : 0,
                        clickedData = that.selectpicker.current.data[$this.parent().index() + position0],
                        clickedIndex = clickedData.index,
                        prevValue = getSelectValues(element),
                        prevIndex = element.selectedIndex,
                        prevOption = element.options[prevIndex],
                        triggerChange = true;

                    // Don't close on multi choice menu
                    if (that.multiple && that.options.maxOptions !== 1) {
                        e.stopPropagation();
                    }

                    e.preventDefault();

                    // Don't run if the select is disabled
                    if (!that.isDisabled() && !$this.parent().hasClass(classNames.DISABLED)) {
                        var option = clickedData.option,
                            $option = $(option),
                            state = option.selected,
                            $optgroup = $option.parent('optgroup'),
                            $optgroupOptions = $optgroup.find('option'),
                            maxOptions = that.options.maxOptions,
                            maxOptionsGrp = $optgroup.data('maxOptions') || false;

                        if (clickedIndex === that.activeIndex) retainActive = true;

                        if (!retainActive) {
                            that.prevActiveIndex = that.activeIndex;
                            that.activeIndex = undefined;
                        }

                        if (!that.multiple) { // Deselect all others if not multi select box
                            if (prevOption) prevOption.selected = false;
                            option.selected = true;
                            that.setSelected(clickedIndex, true);
                        } else { // Toggle the one we have chosen if we are multi select.
                            option.selected = !state;

                            that.setSelected(clickedIndex, !state);
                            $this.trigger('blur');

                            if (maxOptions !== false || maxOptionsGrp !== false) {
                                var maxReached = maxOptions < getSelectedOptions(element).length,
                                    maxReachedGrp = maxOptionsGrp < $optgroup.find('option:selected').length;

                                if ((maxOptions && maxReached) || (maxOptionsGrp && maxReachedGrp)) {
                                    if (maxOptions && maxOptions == 1) {
                                        element.selectedIndex = -1;
                                        option.selected = true;
                                        that.setOptionStatus(true);
                                    } else if (maxOptionsGrp && maxOptionsGrp == 1) {
                                        for (var i = 0; i < $optgroupOptions.length; i++) {
                                            var _option = $optgroupOptions[i];
                                            _option.selected = false;
                                            that.setSelected(_option.liIndex, false);
                                        }

                                        option.selected = true;
                                        that.setSelected(clickedIndex, true);
                                    } else {
                                        var maxOptionsText = typeof that.options.maxOptionsText === 'string' ? [that.options.maxOptionsText, that.options.maxOptionsText] : that.options.maxOptionsText,
                                            maxOptionsArr = typeof maxOptionsText === 'function' ? maxOptionsText(maxOptions, maxOptionsGrp) : maxOptionsText,
                                            maxTxt = maxOptionsArr[0].replace('{n}', maxOptions),
                                            maxTxtGrp = maxOptionsArr[1].replace('{n}', maxOptionsGrp),
                                            $notify = $('<div class="notify"></div>');
                                        // If {var} is set in array, replace it
                                        /** @deprecated */
                                        if (maxOptionsArr[2]) {
                                            maxTxt = maxTxt.replace('{var}', maxOptionsArr[2][maxOptions > 1 ? 0 : 1]);
                                            maxTxtGrp = maxTxtGrp.replace('{var}', maxOptionsArr[2][maxOptionsGrp > 1 ? 0 : 1]);
                                        }

                                        option.selected = false;

                                        that.$menu.append($notify);

                                        if (maxOptions && maxReached) {
                                            $notify.append($('<div>' + maxTxt + '</div>'));
                                            triggerChange = false;
                                            that.$element.trigger('maxReached' + EVENT_KEY);
                                        }

                                        if (maxOptionsGrp && maxReachedGrp) {
                                            $notify.append($('<div>' + maxTxtGrp + '</div>'));
                                            triggerChange = false;
                                            that.$element.trigger('maxReachedGrp' + EVENT_KEY);
                                        }

                                        setTimeout(function () {
                                            that.setSelected(clickedIndex, false);
                                        }, 10);

                                        $notify[0].classList.add('fadeOut');

                                        setTimeout(function () {
                                            $notify.remove();
                                        }, 1050);
                                    }
                                }
                            }
                        }

                        if (!that.multiple || (that.multiple && that.options.maxOptions === 1)) {
                            that.$button.trigger('focus');
                        } else if (that.options.liveSearch) {
                            that.$searchbox.trigger('focus');
                        }

                        // Trigger select 'change'
                        if (triggerChange) {
                            if (that.multiple || prevIndex !== element.selectedIndex) {
                                // $option.prop('selected') is current option state (selected/unselected). prevValue is the value of the select prior to being changed.
                                changedArguments = [option.index, $option.prop('selected'), prevValue];
                                that.$element
                                    .triggerNative('change');
                            }
                        }
                    }
                });

                this.$menu.on('click', 'li.' + classNames.DISABLED + ' a, .' + classNames.POPOVERHEADER + ', .' + classNames.POPOVERHEADER + ' :not(.close)', function (e) {
                    if (e.currentTarget == this) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (that.options.liveSearch && !$(e.target).hasClass('close')) {
                            that.$searchbox.trigger('focus');
                        } else {
                            that.$button.trigger('focus');
                        }
                    }
                });

                this.$menuInner.on('click', '.divider, .dropdown-header', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (that.options.liveSearch) {
                        that.$searchbox.trigger('focus');
                    } else {
                        that.$button.trigger('focus');
                    }
                });

                this.$menu.on('click', '.' + classNames.POPOVERHEADER + ' .close', function () {
                    that.$button.trigger('click');
                });

                this.$searchbox.on('click', function (e) {
                    e.stopPropagation();
                });

                this.$menu.on('click', '.actions-btn', function (e) {
                    if (that.options.liveSearch) {
                        that.$searchbox.trigger('focus');
                    } else {
                        that.$button.trigger('focus');
                    }

                    e.preventDefault();
                    e.stopPropagation();

                    if ($(this).hasClass('bs-select-all')) {
                        that.selectAll();
                    } else {
                        that.deselectAll();
                    }
                });

                this.$element
                    .on('change' + EVENT_KEY, function () {
                        that.render();
                        that.$element.trigger('changed' + EVENT_KEY, changedArguments);
                        changedArguments = null;
                    })
                    .on('focus' + EVENT_KEY, function () {
                        if (!that.options.mobile) that.$button.trigger('focus');
                    });
            },

            liveSearchListener: function () {
                var that = this,
                    noResults = document.createElement('li');

                this.$button.on('click.bs.dropdown.data-api', function () {
                    if (!!that.$searchbox.val()) {
                        that.$searchbox.val('');
                    }
                });

                this.$searchbox.on('click.bs.dropdown.data-api focus.bs.dropdown.data-api touchend.bs.dropdown.data-api', function (e) {
                    e.stopPropagation();
                });

                this.$searchbox.on('input propertychange', function () {
                    var searchValue = that.$searchbox.val();

                    that.selectpicker.search.elements = [];
                    that.selectpicker.search.data = [];

                    if (searchValue) {
                        var i,
                            searchMatch = [],
                            q = searchValue.toUpperCase(),
                            cache = {},
                            cacheArr = [],
                            searchStyle = that._searchStyle(),
                            normalizeSearch = that.options.liveSearchNormalize;

                        if (normalizeSearch) q = normalizeToBase(q);

                        for (var i = 0; i < that.selectpicker.main.data.length; i++) {
                            var li = that.selectpicker.main.data[i];

                            if (!cache[i]) {
                                cache[i] = stringSearch(li, q, searchStyle, normalizeSearch);
                            }

                            if (cache[i] && li.headerIndex !== undefined && cacheArr.indexOf(li.headerIndex) === -1) {
                                if (li.headerIndex > 0) {
                                    cache[li.headerIndex - 1] = true;
                                    cacheArr.push(li.headerIndex - 1);
                                }

                                cache[li.headerIndex] = true;
                                cacheArr.push(li.headerIndex);

                                cache[li.lastIndex + 1] = true;
                            }

                            if (cache[i] && li.type !== 'optgroup-label') cacheArr.push(i);
                        }

                        for (var i = 0, cacheLen = cacheArr.length; i < cacheLen; i++) {
                            var index = cacheArr[i],
                                prevIndex = cacheArr[i - 1],
                                li = that.selectpicker.main.data[index],
                                liPrev = that.selectpicker.main.data[prevIndex];

                            if (li.type !== 'divider' || (li.type === 'divider' && liPrev && liPrev.type !== 'divider' && cacheLen - 1 !== i)) {
                                that.selectpicker.search.data.push(li);
                                searchMatch.push(that.selectpicker.main.elements[index]);
                            }
                        }

                        that.activeIndex = undefined;
                        that.noScroll = true;
                        that.$menuInner.scrollTop(0);
                        that.selectpicker.search.elements = searchMatch;
                        that.createView(true);

                        if (!searchMatch.length) {
                            noResults.className = 'no-results';
                            noResults.innerHTML = that.options.noneResultsText.replace('{0}', '"' + htmlEscape(searchValue) + '"');
                            that.$menuInner[0].firstChild.appendChild(noResults);
                        }
                    } else {
                        that.$menuInner.scrollTop(0);
                        that.createView(false);
                    }
                });
            },

            _searchStyle: function () {
                return this.options.liveSearchStyle || 'contains';
            },

            val: function (value) {
                var element = this.$element[0];

                if (typeof value !== 'undefined') {
                    var prevValue = getSelectValues(element);

                    changedArguments = [null, null, prevValue];

                    this.$element
                        .val(value)
                        .trigger('changed' + EVENT_KEY, changedArguments);

                    if (this.$newElement.hasClass(classNames.SHOW)) {
                        if (this.multiple) {
                            this.setOptionStatus(true);
                        } else {
                            var liSelectedIndex = (element.options[element.selectedIndex] || {}).liIndex;

                            if (typeof liSelectedIndex === 'number') {
                                this.setSelected(this.selectedIndex, false);
                                this.setSelected(liSelectedIndex, true);
                            }
                        }
                    }

                    this.render();

                    changedArguments = null;

                    return this.$element;
                } else {
                    return this.$element.val();
                }
            },

            changeAll: function (status) {
                if (!this.multiple) return;
                if (typeof status === 'undefined') status = true;

                var element = this.$element[0],
                    previousSelected = 0,
                    currentSelected = 0,
                    prevValue = getSelectValues(element);

                element.classList.add('bs-select-hidden');

                for (var i = 0, data = this.selectpicker.current.data, len = data.length; i < len; i++) {
                    var liData = data[i],
                        option = liData.option;

                    if (option && !liData.disabled && liData.type !== 'divider') {
                        if (liData.selected) previousSelected++;
                        option.selected = status;
                        if (status === true) currentSelected++;
                    }
                }

                element.classList.remove('bs-select-hidden');

                if (previousSelected === currentSelected) return;

                this.setOptionStatus();

                changedArguments = [null, null, prevValue];

                this.$element
                    .triggerNative('change');
            },

            selectAll: function () {
                return this.changeAll(true);
            },

            deselectAll: function () {
                return this.changeAll(false);
            },

            toggle: function (e) {
                e = e || window.event;

                if (e) e.stopPropagation();

                this.$button.trigger('click.bs.dropdown.data-api');
            },

            keydown: function (e) {
                var $this = $(this),
                    isToggle = $this.hasClass('dropdown-toggle'),
                    $parent = isToggle ? $this.closest('.dropdown') : $this.closest(Selector.MENU),
                    that = $parent.data('this'),
                    $items = that.findLis(),
                    index,
                    isActive,
                    liActive,
                    activeLi,
                    offset,
                    updateScroll = false,
                    downOnTab = e.which === keyCodes.TAB && !isToggle && !that.options.selectOnTab,
                    isArrowKey = REGEXP_ARROW.test(e.which) || downOnTab,
                    scrollTop = that.$menuInner[0].scrollTop,
                    isVirtual = that.isVirtual(),
                    position0 = isVirtual === true ? that.selectpicker.view.position0 : 0;

                // do nothing if a function key is pressed
                if (e.which >= 112 && e.which <= 123) return;

                isActive = that.$newElement.hasClass(classNames.SHOW);

                if (
                    !isActive &&
                    (
                        isArrowKey ||
                        (e.which >= 48 && e.which <= 57) ||
                        (e.which >= 96 && e.which <= 105) ||
                        (e.which >= 65 && e.which <= 90)
                    )
                ) {
                    that.$button.trigger('click.bs.dropdown.data-api');

                    if (that.options.liveSearch) {
                        that.$searchbox.trigger('focus');
                        return;
                    }
                }

                if (e.which === keyCodes.ESCAPE && isActive) {
                    e.preventDefault();
                    that.$button.trigger('click.bs.dropdown.data-api').trigger('focus');
                }

                if (isArrowKey) { // if up or down
                    if (!$items.length) return;

                    liActive = that.selectpicker.main.elements[that.activeIndex];
                    index = liActive ? Array.prototype.indexOf.call(liActive.parentElement.children, liActive) : -1;

                    if (index !== -1) {
                        that.defocusItem(liActive);
                    }

                    if (e.which === keyCodes.ARROW_UP) { // up
                        if (index !== -1) index--;
                        if (index + position0 < 0) index += $items.length;

                        if (!that.selectpicker.view.canHighlight[index + position0]) {
                            index = that.selectpicker.view.canHighlight.slice(0, index + position0).lastIndexOf(true) - position0;
                            if (index === -1) index = $items.length - 1;
                        }
                    } else if (e.which === keyCodes.ARROW_DOWN || downOnTab) { // down
                        index++;
                        if (index + position0 >= that.selectpicker.view.canHighlight.length) index = 0;

                        if (!that.selectpicker.view.canHighlight[index + position0]) {
                            index = index + 1 + that.selectpicker.view.canHighlight.slice(index + position0 + 1).indexOf(true);
                        }
                    }

                    e.preventDefault();

                    var liActiveIndex = position0 + index;

                    if (e.which === keyCodes.ARROW_UP) { // up
                        // scroll to bottom and highlight last option
                        if (position0 === 0 && index === $items.length - 1) {
                            that.$menuInner[0].scrollTop = that.$menuInner[0].scrollHeight;

                            liActiveIndex = that.selectpicker.current.elements.length - 1;
                        } else {
                            activeLi = that.selectpicker.current.data[liActiveIndex];
                            offset = activeLi.position - activeLi.height;

                            updateScroll = offset < scrollTop;
                        }
                    } else if (e.which === keyCodes.ARROW_DOWN || downOnTab) { // down
                        // scroll to top and highlight first option
                        if (index === 0) {
                            that.$menuInner[0].scrollTop = 0;

                            liActiveIndex = 0;
                        } else {
                            activeLi = that.selectpicker.current.data[liActiveIndex];
                            offset = activeLi.position - that.sizeInfo.menuInnerHeight;

                            updateScroll = offset > scrollTop;
                        }
                    }

                    liActive = that.selectpicker.current.elements[liActiveIndex];

                    that.activeIndex = that.selectpicker.current.data[liActiveIndex].index;

                    that.focusItem(liActive);

                    that.selectpicker.view.currentActive = liActive;

                    if (updateScroll) that.$menuInner[0].scrollTop = offset;

                    if (that.options.liveSearch) {
                        that.$searchbox.trigger('focus');
                    } else {
                        $this.trigger('focus');
                    }
                } else if (
                    (!$this.is('input') && !REGEXP_TAB_OR_ESCAPE.test(e.which)) ||
                    (e.which === keyCodes.SPACE && that.selectpicker.keydown.keyHistory)
                ) {
                    var searchMatch,
                        matches = [],
                        keyHistory;

                    e.preventDefault();

                    that.selectpicker.keydown.keyHistory += keyCodeMap[e.which];

                    if (that.selectpicker.keydown.resetKeyHistory.cancel) clearTimeout(that.selectpicker.keydown.resetKeyHistory.cancel);
                    that.selectpicker.keydown.resetKeyHistory.cancel = that.selectpicker.keydown.resetKeyHistory.start();

                    keyHistory = that.selectpicker.keydown.keyHistory;

                    // if all letters are the same, set keyHistory to just the first character when searching
                    if (/^(.)\1+$/.test(keyHistory)) {
                        keyHistory = keyHistory.charAt(0);
                    }

                    // find matches
                    for (var i = 0; i < that.selectpicker.current.data.length; i++) {
                        var li = that.selectpicker.current.data[i],
                            hasMatch;

                        hasMatch = stringSearch(li, keyHistory, 'startsWith', true);

                        if (hasMatch && that.selectpicker.view.canHighlight[i]) {
                            matches.push(li.index);
                        }
                    }

                    if (matches.length) {
                        var matchIndex = 0;

                        $items.removeClass('active').find('a').removeClass('active');

                        // either only one key has been pressed or they are all the same key
                        if (keyHistory.length === 1) {
                            matchIndex = matches.indexOf(that.activeIndex);

                            if (matchIndex === -1 || matchIndex === matches.length - 1) {
                                matchIndex = 0;
                            } else {
                                matchIndex++;
                            }
                        }

                        searchMatch = matches[matchIndex];

                        activeLi = that.selectpicker.main.data[searchMatch];

                        if (scrollTop - activeLi.position > 0) {
                            offset = activeLi.position - activeLi.height;
                            updateScroll = true;
                        } else {
                            offset = activeLi.position - that.sizeInfo.menuInnerHeight;
                            // if the option is already visible at the current scroll position, just keep it the same
                            updateScroll = activeLi.position > scrollTop + that.sizeInfo.menuInnerHeight;
                        }

                        liActive = that.selectpicker.main.elements[searchMatch];

                        that.activeIndex = matches[matchIndex];

                        that.focusItem(liActive);

                        if (liActive) liActive.firstChild.focus();

                        if (updateScroll) that.$menuInner[0].scrollTop = offset;

                        $this.trigger('focus');
                    }
                }

                // Select focused option if "Enter", "Spacebar" or "Tab" (when selectOnTab is true) are pressed inside the menu.
                if (
                    isActive &&
                    (
                        (e.which === keyCodes.SPACE && !that.selectpicker.keydown.keyHistory) ||
                        e.which === keyCodes.ENTER ||
                        (e.which === keyCodes.TAB && that.options.selectOnTab)
                    )
                ) {
                    if (e.which !== keyCodes.SPACE) e.preventDefault();

                    if (!that.options.liveSearch || e.which !== keyCodes.SPACE) {
                        that.$menuInner.find('.active a').trigger('click', true); // retain active class
                        $this.trigger('focus');

                        if (!that.options.liveSearch) {
                            // Prevent screen from scrolling if the user hits the spacebar
                            e.preventDefault();
                            // Fixes spacebar selection of dropdown items in FF & IE
                            $(document).data('spaceSelect', true);
                        }
                    }
                }
            },

            mobile: function () {
                this.$element[0].classList.add('mobile-device');
            },

            refresh: function () {
                // update options if data attributes have been changed
                var config = $.extend({}, this.options, this.$element.data());
                this.options = config;

                this.checkDisabled();
                this.setStyle();
                this.render();
                this.buildData();
                this.buildList();
                this.setWidth();

                this.setSize(true);

                this.$element.trigger('refreshed' + EVENT_KEY);
            },

            hide: function () {
                this.$newElement.hide();
            },

            show: function () {
                this.$newElement.show();
            },

            remove: function () {
                this.$newElement.remove();
                this.$element.remove();
            },

            destroy: function () {
                this.$newElement.before(this.$element).remove();

                if (this.$bsContainer) {
                    this.$bsContainer.remove();
                } else {
                    this.$menu.remove();
                }

                this.$element
                    .off(EVENT_KEY)
                    .removeData('selectpicker')
                    .removeClass('bs-select-hidden selectpicker');

                $(window).off(EVENT_KEY + '.' + this.selectId);
            }
        };

        // SELECTPICKER PLUGIN DEFINITION
        // ==============================
        function Plugin (option) {
            // get the args of the outer function..
            var args = arguments;
            // The arguments of the function are explicitly re-defined from the argument list, because the shift causes them
            // to get lost/corrupted in android 2.3 and IE9 #715 #775
            var _option = option;

            [].shift.apply(args);

            // if the version was not set successfully
            if (!version.success) {
                // try to retreive it again
                try {
                    version.full = ($.fn.dropdown.Constructor.VERSION || '').split(' ')[0].split('.');
                } catch (err) {
                    // fall back to use BootstrapVersion if set
                    if (Selectpicker.BootstrapVersion) {
                        version.full = Selectpicker.BootstrapVersion.split(' ')[0].split('.');
                    } else {
                        version.full = [version.major, '0', '0'];

                        console.warn(
                            'There was an issue retrieving Bootstrap\'s version. ' +
                            'Ensure Bootstrap is being loaded before bootstrap-select and there is no namespace collision. ' +
                            'If loading Bootstrap asynchronously, the version may need to be manually specified via $.fn.selectpicker.Constructor.BootstrapVersion.',
                            err
                        );
                    }
                }

                version.major = version.full[0];
                version.success = true;
            }

            if (version.major === '4') {
                // some defaults need to be changed if using Bootstrap 4
                // check to see if they have already been manually changed before forcing them to update
                var toUpdate = [];

                if (Selectpicker.DEFAULTS.style === classNames.BUTTONCLASS) toUpdate.push({ name: 'style', className: 'BUTTONCLASS' });
                if (Selectpicker.DEFAULTS.iconBase === classNames.ICONBASE) toUpdate.push({ name: 'iconBase', className: 'ICONBASE' });
                if (Selectpicker.DEFAULTS.tickIcon === classNames.TICKICON) toUpdate.push({ name: 'tickIcon', className: 'TICKICON' });

                classNames.DIVIDER = 'dropdown-divider';
                classNames.SHOW = 'show';
                classNames.BUTTONCLASS = 'btn-light';
                classNames.POPOVERHEADER = 'popover-header';
                classNames.ICONBASE = '';
                classNames.TICKICON = 'bs-ok-default';

                for (var i = 0; i < toUpdate.length; i++) {
                    var option = toUpdate[i];
                    Selectpicker.DEFAULTS[option.name] = classNames[option.className];
                }
            }

            var value;
            var chain = this.each(function () {
                var $this = $(this);
                if ($this.is('select')) {
                    var data = $this.data('selectpicker'),
                        options = typeof _option == 'object' && _option;

                    if (!data) {
                        var dataAttributes = $this.data();

                        for (var dataAttr in dataAttributes) {
                            if (dataAttributes.hasOwnProperty(dataAttr) && $.inArray(dataAttr, DISALLOWED_ATTRIBUTES) !== -1) {
                                delete dataAttributes[dataAttr];
                            }
                        }

                        var config = $.extend({}, Selectpicker.DEFAULTS, $.fn.selectpicker.defaults || {}, dataAttributes, options);
                        config.template = $.extend({}, Selectpicker.DEFAULTS.template, ($.fn.selectpicker.defaults ? $.fn.selectpicker.defaults.template : {}), dataAttributes.template, options.template);
                        $this.data('selectpicker', (data = new Selectpicker(this, config)));
                    } else if (options) {
                        for (var i in options) {
                            if (options.hasOwnProperty(i)) {
                                data.options[i] = options[i];
                            }
                        }
                    }

                    if (typeof _option == 'string') {
                        if (data[_option] instanceof Function) {
                            value = data[_option].apply(data, args);
                        } else {
                            value = data.options[_option];
                        }
                    }
                }
            });

            if (typeof value !== 'undefined') {
                // noinspection JSUnusedAssignment
                return value;
            } else {
                return chain;
            }
        }

        var old = $.fn.selectpicker;
        $.fn.selectpicker = Plugin;
        $.fn.selectpicker.Constructor = Selectpicker;

        // SELECTPICKER NO CONFLICT
        // ========================
        $.fn.selectpicker.noConflict = function () {
            $.fn.selectpicker = old;
            return this;
        };

        // get Bootstrap's keydown event handler for either Bootstrap 4 or Bootstrap 3
        var bootstrapKeydown = $.fn.dropdown.Constructor._dataApiKeydownHandler || $.fn.dropdown.Constructor.prototype.keydown;

        $(document)
            .off('keydown.bs.dropdown.data-api')
            .on('keydown.bs.dropdown.data-api', ':not(.bootstrap-select) > [data-toggle="dropdown"]', bootstrapKeydown)
            .on('keydown.bs.dropdown.data-api', ':not(.bootstrap-select) > .dropdown-menu', bootstrapKeydown)
            .on('keydown' + EVENT_KEY, '.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bootstrap-select .bs-searchbox input', Selectpicker.prototype.keydown)
            .on('focusin.modal', '.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bootstrap-select .bs-searchbox input', function (e) {
                e.stopPropagation();
            });

        // SELECTPICKER DATA-API
        // =====================
        $(window).on('load' + EVENT_KEY + '.data-api', function () {
            $('.selectpicker').each(function () {
                var $selectpicker = $(this);
                Plugin.call($selectpicker, $selectpicker.data());
            })
        });
    })(jQuery);


}));
//# sourceMappingURL=bootstrap-select.js.map