/*global
   $ jQuery
*/

var VerticalThumbnails = (function ($, document) {
    'use-strict';

    var VerticalSlide = function (carousel, wrapper, state) {
        this.carousel = carousel;
        this.wrapper = wrapper;
        this.track = document.createElement('div');
        this.children = [];
        this.totalVisible = 4;
        this.margin = 0;
        // example of state of objet, children should 
        // probably be part of state but i guess they are
        // no matter what
        this.state = state || {
            firstIndex: 0,
            lastIndex: 3,
            currentActiveIndex: 0
        };

    };

    VerticalSlide.prototype.init = function () {
        var _self = this;
        var i;

        // extract all the children
        for (i = 0; i < this.wrapper.children.length; i += 1) {
            this.children.push(this.wrapper.children[i]);
        }

        // empty the elements in the wrapper
        while (this.wrapper.firstChild) {
            this.wrapper.removeChild(this.wrapper.firstChild);
        }

        // append all of the children into the track
        this.children.forEach(function (child) {
            child.addEventListener('click', function (e) {
                // select child as active item in the carousel
                e.preventDefault();
                _self.setActive(this);
            });

            // append element to the track
            _self.track.appendChild(child);
        });

        // append track into the wrapper
        this.track.classList.add('vertical-slider--track');
        this.wrapper.appendChild(this.track);

        // create next and previous buttons
        var prev = document.querySelector('a.prev');
        var next = document.querySelector('a.next');

        //bind actions to button
        next.addEventListener('click', function (e) {
            e.preventDefault();
            _self.move(+1);
        });

        prev.addEventListener('click', function (e) {
            e.preventDefault();
            _self.move(-1);
        });

        this.track.style.willChange = "top";
        this.track.style.transition = "top 0.3s";
        this.setChildSpacing();
    };

    VerticalSlide.prototype.setChildSpacing = function () {

        var wrapperHeight = this.wrapper.getBoundingClientRect().height,
            totalHeight = 0,
            margin = this.margin,
            i;

        for (i = 0; i <= this.totalVisible; i += 1) {
            totalHeight += this.children[i].getBoundingClientRect().height;
        }

        margin = ((wrapperHeight - totalHeight) / this.totalVisible) / 2;

        this.children.forEach(function (child) {
            child.style.margin = margin + "px";
        });

        this.margin = margin;
    };


    // Takes and object as an argument
    VerticalSlide.prototype.changeState = function (object) {

        var that = this,
            newStateObject = {};

        Object.keys(this.state).forEach(function (key) {
            // argument object contains this state
            if (object.hasOwnProperty(key.toString())) {
                newStateObject[key] = object[key];
                return;
            }

            newStateObject[key] = that.state[key];
        });

        return (function (newStateObject) {
            that.state = newStateObject;
        }(newStateObject));
    };

    VerticalSlide.prototype.canMove = function (amount) {

        var isPositive = function (n) {
            return n >= 0;
        };

        if (isPositive(amount)) {
            return this.state.lastIndex <= this.children.length - 1;
        }

        return this.state.firstIndex > 0;
    };

    VerticalSlide.prototype.moveOwlSlider = function (amount, index) {

        if (amount < 0) {
            $(this.carousel).trigger('prev.owl.carousel');
        } else {
            $(this.carousel).trigger('next.owl.carousel');
        }

        if (index) {
            amount = index;
        }

        this.changeState({
            currentActiveIndex: this.state.currentActiveIndex + amount
        });

    };

    VerticalSlide.prototype.move = function (amount) {

        if (this.canMove(amount)) {
            // move the track
            this.track.style.top = this.calculateDistance(amount) + "px";

            // move the owl carousel with vertical slider
            this.changeState({
                firstIndex: this.state.firstIndex + amount,
                lastIndex: this.state.lastIndex + amount
            });
        }

        this.moveOwlSlider(amount);
    };

    VerticalSlide.prototype.calculateDistance = function (amount) {

        var heightToMove = 0,
            el;

        function removePX(string) {
            return +string.replace(/px/g, '');
        }
        // if amount is less than 0 then we are down
        // else we are moving up
        if (amount < 0) {
            el = this.children[this.state.lastIndex - 1];
            heightToMove = el.getBoundingClientRect().height + this.margin * 2;
        } else {
            el = this.children[this.state.firstIndex];
            heightToMove = -(el.getBoundingClientRect().height) - (this.margin * 2);
        }

        if (this.track.style.top) {
            return heightToMove + removePX(this.track.style.top);
        }

        return heightToMove;

    };

    VerticalSlide.prototype.setActive = function (el) {

        this.changeState({
            currentActive: el.dataset.index
        });

        $(this.carousel).trigger('to.owl.carousel', [$(el).data('index'), 300, true]);
    };

    var api = {
        // we only want to expose this create funciton
        create: function (carouselName, wrapperEl, state) {
            var vs = new VerticalSlide(carouselName, wrapperEl, state);
            vs.init();
        }

        // perhaps I should expose a next and previous functoin
        // what do you think? 
        // this would allow the carousel to sink up with the 
        // thumb nails, right now if you swipe right it
        // goes out of sync
    };

    return (function () {
        return api;
    }());

}(jQuery, document));
