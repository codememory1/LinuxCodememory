// const block = document.querySelector('.block');
// const container = document.querySelector('.container');

// let clicedBlock = false;

// block.onmousedown = (event) => {
//     clicedBlock = true;
//     block.style.position = 'absolute';
//     block.style.opacity = '0.5';
// }

// block.ondragstart = function() {
//     return false;
// };

// block.onmousemove = (e) => {
//     if(clicedBlock === true)
//     {
//         const x = e.pageX - block.offsetWidth / 2;
//         const y = e.pageY - block.offsetHeight / 2;

//         if(x > container.offsetLeft && x < container.offsetWidth - 20 && y > container.offsetTop && y < container.offsetHeight - 50)
//         {
//             block.style.left = e.pageX - block.offsetWidth / 2 + 'px';
//             block.style.top = e.pageY - block.offsetHeight / 2 + 'px';
//         }
//     }
// }

// block.onmouseup = (event) => {
//     block.style.opacity = '1';
//     clicedBlock = false;
// }

// // block.onmouseout = (event) => {
// //     block.style.opacity = '1';
// //     clicedBlock = false;
// // }

class CarryOver
{

    #clickStatus = false;
    #element;
    #documentElement;
    #defaultPositionX;
    #defaultPositionY;

    Event = [];
    #Positions = [];
    #motionPositions = [];
    #movePosition = [];

    constructor(identifier)
    {
        if(typeof identifier === undefined || identifier === null) {
            throw new Error('Укажите индитификатор блока.');
        }
        else {
            this.#element = identifier ?? null;
            this.#documentElement = document.querySelector(this.#element);
            this.#documentElement.style.position = 'absolute';
            this.#defaultPositionX = this.#documentElement.pageX;
            this.#defaultPositionY = this.#documentElement.pageY;
        }
    }

    #downEvent(event)
    {
        this.#clickStatus = true;
        this.Event['down'] = event || window.Event;

        return this;
    }

    #upEvent(event)
    {

        this.#clickStatus = false;

        return this;
    }

    #moveEvent(event)
    {
        this.Event['move'] = event || window.Event;

        this.#Positions['x'] = this.getEvent('move').pageX - this.#documentElement.offsetWidth / 2;
        this.#Positions['y'] = this.getEvent('move').pageY - this.#documentElement.offsetHeight / 2;

        if(this.#motionPositions.length > 0)
        {
            if(this.#position.x >= this.#motionPositions.x[0] && this.#position.x <= this.#motionPositions.x[1]
                && this.#position.y >= this.#motionPositions.y[0] && this.#position.y <= this.#motionPositions.y[1])
            {
                this.#documentElement.style.left = this.#position.x + 'px';
                this.#documentElement.style.top = this.#position.y + 'px';
            }
        }
        else {
            this.#documentElement.style.left = this.#position.x + 'px';
            this.#documentElement.style.top = this.#position.y + 'px';
        }

        return this;
    }

    getEvent(event)
    {
        return this.Event[event] || this.Event;
    }

    setPositionX(start, end)
    {
        this.#motionPositions['x'] = [start, end];

        return this;
    }

    setPositionY(start, end)
    {
        this.#motionPositions['y'] = [start, end];

        return this;
    }

    setMovePositionX(start, end)
    {
        this.#movePosition['x'] = [start, end];

        return this;
    }

    setMovePositionY(start, end)
    {
        this.#movePosition['y'] = [start, end];

        return this;
    }

    get #position()
    {
        return this.#Positions;
    }

    #forceDown()
    {
        this.#documentElement.onmousedown = (event) => {
            this.#downEvent(event);
        }

        return this;
    }

    #forceMove()
    {
        this.#documentElement.onmousemove = (event) => {
            if(this.#clickStatus === true)
            {
                this.#moveEvent(event);
            }
        }

        return this;
    }

    #forseUp()
    {
        this.#documentElement.onmouseup = (event) => {
            this.#upEvent(event);
            if(event.pageX > this.#movePosition['x'][0] || event.pageX < this.#movePosition['x'][1] || event.pageY > this.#movePosition['y'][0] || event.pageY < this.#movePosition['y'][1])
            {
                this.#documentElement.style.left = 50 + 'px';
                this.#documentElement.style.top = 50 + 'px';
            }
        }

        return this;
    }

    #forceOut()
    {
        this.#documentElement.onmouseout = (event) => {
            this.#upEvent(event);
        }

        return this;
    }

    force()
    {
        this
        .#forceDown()
        .#forceMove()
        .#forseUp()
        .#forceOut();

        console.log(this.#movePosition);
    }
    
}

const c = new CarryOver('.block');
const c2 = new CarryOver('.block2');

c.setMovePositionX(300, 400).setMovePositionY(300, 400).force();
c2.force();
