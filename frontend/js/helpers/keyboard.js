$(function () {
    $(document).on('focus', 'input', function () {
        $('body').find('.activeFocus').removeClass('activeFocus');
        if (!$(this).hasClass('activeFocus')) {
            $(this).addClass('activeFocus');

            var type = $(this).attr('type'), name = $(this).attr('name');
            if (type === 'text' || type === 'password') {
                if (name === 'email')
                    type = name;
                switch (type) {
                    case 'text':
                        OpenKeyboard('activeFocus', 'NUMERIC');
                        break;
                    case 'password':
                        OpenKeyboard('activeFocus', 'FULL');
                        break;
                    case 'email':
                        OpenKeyboard('activeFocus', 'FULL');
                        break;
                    default :
                        break;
                }
            }

        }
        return true;
    });
    $(document).on('click', function (event) {
        event.stopPropagation();
        //  console.log(event.target); timer_popup_btn
        if (!($(event.target).hasClass('keyboard_button')) && !($(event.target).hasClass('timer_popup_btn')) && !($(event.target).attr('type') === 'text') && !($(event.target).attr('type') === 'password')) {
            ClearKeybord();
        }
    });
});

var NUM_KEYS = ["1", "2", "h3", "E", "4", "5", "h6", "E", "7", "8", "h9", "E", "#D", "0", "hDel"];

var FULL_KEYS_EN_UP = [
    "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P", "NONE", "7", "8", "9",
    "A", "S", "D", "F", "G", "H", "J", "K", "L", ".", "NONE", "4", "5", "6",
    "Z", "X", "C", "V", "B", "N", "M", "@", "_", "-", "NONE", "1", "2", "3",
    "UP", "NONE", "SPACE", "NONE", "NONE", "#D", "0", "Del"];
var FULL_KEYS_EN_LO = [
    "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "NONE", "7", "8", "9",
    "a", "s", "d", "f", "g", "h", "j", "k", "l", ".", "NONE", "4", "5", "6",
    "z", "x", "c", "v", "b", "n", "m", "@", "_", "-", "NONE", "1", "2", "3",
    "UP", "NONE", "SPACE", "NONE", "NONE", "#D", "0", "Del"];

var FULL_KEYS_RU = [
    "Я", "В", "Е", "Р", "Т", "Ы", "У", "И", "О", "П", "NONE", "7", "8", "9",
    "А", "С", "Д", "Ф", "Г", "Х", "Й", "К", "Л", ".", "NONE", "4", "5", "6",
    "З", "Ь", "Ц", "Ж", "Б", "Н", "М", "@", "_", "-", "NONE", "1", "2", "3",
    "Ш", "Щ", "Ч", "Ю", "Э", "", "", "", "", "", "NONE", "#D", "0", "Del",
    "HY", "RU", "EN", "SPACE", "NONE", "NONE", "NONE", "NONE"];

var FULL_KEYS_HY = [
    "Է", "Թ", "Փ", "Ձ", "Ջ", "և", "Ր", "Չ", "Ճ", "Ժ", "NONE", "7", "8", "9",
    "Ք", "Ո", "Ե", "Ռ", "Տ", "Ը", "Ւ", "Ի", "Օ", "Պ", "NONE", "4", "5", "6",
    "Ա", "Ս", "Դ", "Ֆ", "Գ", "Հ", "Յ", "Կ", "Լ", "-", "NONE", "1", "2", "3",
    "Զ", "Ղ", "Ց", "Վ", "Բ", "Ն", "Մ", "Խ", "Ծ", "Շ", "NONE", "#D", "0", "Del",
    "HY", "RU", "EN", "SPACE", "NONE", "NONE", "NONE", "NONE"];



function OpenKeyboard(obj, lkeyboard) {




    var key_bd = document.getElementById("menu_keyboard");
    key_bd.innerHTML = "";


    if (lkeyboard === 'NUMERIC') {
        var key1 = document.createElement("div");
        key1.className = "num_keypad";

        for (var i in NUM_KEYS) {
            if (NUM_KEYS[i] !== "E") {
                var wrap = document.createElement("div");

                if (NUM_KEYS[i].substr(0, 1) === "#")
                {
                    wrap.className = "keyboard_button num_keyboard_button_" + NUM_KEYS[i].substr(1, 1);
                } else
                {
                    if (NUM_KEYS[i].substr(0, 1) === "h")
                    {
                        wrap.className = "num_keyboard_button_r keyboard_button";

                        wrap.innerHTML = NUM_KEYS[i].substr(1, NUM_KEYS[i].length - 1);
                    } else
                    {
                        wrap.className = "num_keyboard_button keyboard_button";
                        wrap.innerHTML = NUM_KEYS[i];
                    }
                }
                key1.appendChild(wrap);
                if (NUM_KEYS[i].substr(0, 1) === "h") {
                    wrap.setAttribute('onmousedown', "KeyPress('" + obj + "','" + NUM_KEYS[i].substr(1, NUM_KEYS[i].length - 1) + "')");
                } else
                    wrap.setAttribute('onmousedown', "KeyPress('" + obj + "','" + NUM_KEYS[i] + "')");
            } else
            {
                var wrap = document.createElement('hr');
                wrap.className = "keyboard keyboard_button";
                key1.appendChild(wrap);
            }
        }
        key_bd.appendChild(key1);
    }






    if (lkeyboard === 'FULL') {
        ChangeKeyboard('EN', obj, true);
    }


}

function ClearKeybord() {
    $('#menu_keyboard').html('');
}



function ChangeKeyboard(lang, obj, lowerCase) {




    var key_bd = document.getElementById("menu_keyboard");
    key_bd.innerHTML = "";

    var key1 = document.createElement("div");
    key1.className = "full_keypad cf";

    var FULL_KEYS = FULL_KEYS_EN_UP;


    if (lowerCase) {
        FULL_KEYS = FULL_KEYS_EN_LO;
    } else {
        FULL_KEYS = FULL_KEYS_EN_UP;
    }

    for (var i in FULL_KEYS) {

        var wrap = document.createElement("div");

        if (FULL_KEYS[i].substr(0, 1) == "#")
        {
            wrap.className = "keyboard_button keyboard_button_" + FULL_KEYS[i].substr(1, 1);
        } else if (FULL_KEYS[i] == "NONE")
        {
            wrap.className = "keyboard_button_none keyboard_button";
        } else if (FULL_KEYS[i] == "SPACE")
        {
            wrap.className = "keyboard_button_space keyboard_button";
        } else if (FULL_KEYS[i] == "UP")
        {
            wrap.className = "keyboard_button_up keyboard_button";
        } else
        {
            wrap.className = "keyboard_button";
            wrap.innerText = FULL_KEYS[i];
        }


        wrap.setAttribute('onclick', "KeyPress('" + obj + "','" + FULL_KEYS[i] + "')");

        key1.appendChild(wrap);
    }

    key_bd.appendChild(key1);

}


function KeyPress(obj, key) {

    var el = $('.' + obj);

    if (key === 'Del')
    {
        el.val('');
         el.trigger('input');

    } else if (key === "SPACE")
        el.val(el.val() + "\u00A0");// = el.innerText + "\u00A0";
    else if (key === "#D")
    {
        el.val(el.val().substring(0, el.val().length - 1));
        el.trigger('input');
    } else if (key === "NONE")
    {
    } else if (key === "LOW") {
        ChangeKeyboard('EN', obj, true);
    } else if (key === "UP") {
        ChangeKeyboard('EN', obj, false);
    } else {
        el.val(el.val() + key);
        el.focus().trigger('change');
    }

}

