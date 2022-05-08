/* anytime.5.2.0.min.js
Copyright Andrew M. Andrews III and other contributors.
License: MIT-Style (see uncompressed anytime.js source) */
var AnyTime = {
    version: "5.2.0",
    pad: function (a, b) {
        for (var c = String(Math.abs(a)); c.length < b; ) c = "0" + c;
        return 0 > a && (c = "-" + c), c;
    },
};
!(function (a) {
    var b = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
        c = !1,
        d = [];
    (a.fn.AnyTime_picker = function (a) {
        return this.each(function () {
            AnyTime.picker(this.id, a);
        });
    }),
        (a.fn.AnyTime_noPicker = function () {
            return this.each(function () {
                AnyTime.noPicker(this.id);
            });
        }),
        (a.fn.AnyTime_setCurrent = function (a) {
            return this.each(function () {
                AnyTime.setCurrent(this.id, a);
            });
        }),
        (a.fn.AnyTime_setEarliest = function (a) {
            return this.each(function () {
                AnyTime.setEarliest(this.id, a);
            });
        }),
        (a.fn.AnyTime_setLatest = function (a) {
            return this.each(function () {
                AnyTime.setLatest(this.id, a);
            });
        }),
        (a.fn.AnyTime_current = function (a, b) {
            a
                ? (this.removeClass("AnyTime-out-btn ui-state-default ui-state-disabled ui-state-active"), this.addClass("AnyTime-cur-btn ui-state-default ui-state-active"))
                : (this.removeClass("AnyTime-cur-btn ui-state-active"), b ? this.removeClass("AnyTime-out-btn ui-state-disabled") : this.addClass("AnyTime-out-btn ui-state-disabled"));
        }),
        (a.fn.AnyTime_clickCurrent = function () {
            this.find(".AnyTime-cur-btn").triggerHandler("click");
        }),
        a(document).ready(function () {
            for (var a in d) Array.prototype[a] || d[a].onReady();
            c = !0;
        }),
        (AnyTime.Converter = function (b) {
            var c = 0,
                d = 9,
                e = 9,
                f = 6,
                g = 3,
                h = Number.MIN_VALUE,
                i = Number.MIN_VALUE,
                j = Number.MIN_VALUE,
                k = -1,
                l = Number.MIN_VALUE,
                m = -1,
                n = !1;
            (this.fmt = "%Y-%m-%d %T"),
                (this.dAbbr = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]),
                (this.dNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]),
                (this.eAbbr = ["BCE", "CE"]),
                (this.mAbbr = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]),
                (this.mNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]),
                (this.baseYear = null),
                (this.dAt = function (a, b) {
                    return a.charCodeAt(b) >= "0".charCodeAt(0) && a.charCodeAt(b) <= "9".charCodeAt(0);
                }),
                (this.format = function (a) {
                    var b = new Date(a.getTime());
                    h == Number.MIN_VALUE && j != Number.MIN_VALUE && b.setTime(b.getTime() + 6e4 * b.getTimezoneOffset() + 6e4 * j);
                    for (var d, e = "", f = 0; c > f; f++)
                        if ("%" != this.fmt.charAt(f)) e += this.fmt.charAt(f);
                        else {
                            var g = this.fmt.charAt(f + 1);
                            switch (g) {
                                case "a":
                                    e += this.dAbbr[b.getDay()];
                                    break;
                                case "B":
                                    b.getFullYear() < 0 && (e += this.eAbbr[0]);
                                    break;
                                case "b":
                                    e += this.mAbbr[b.getMonth()];
                                    break;
                                case "C":
                                    b.getFullYear() > 0 && (e += this.eAbbr[1]);
                                    break;
                                case "c":
                                    e += b.getMonth() + 1;
                                    break;
                                case "d":
                                    (d = b.getDate()), 10 > d && (e += "0"), (e += String(d));
                                    break;
                                case "D":
                                    if (((d = String(b.getDate())), (e += d), 2 == d.length && "1" == d.charAt(0))) e += "th";
                                    else
                                        switch (d.charAt(d.length - 1)) {
                                            case "1":
                                                e += "st";
                                                break;
                                            case "2":
                                                e += "nd";
                                                break;
                                            case "3":
                                                e += "rd";
                                                break;
                                            default:
                                                e += "th";
                                        }
                                    break;
                                case "E":
                                    e += this.eAbbr[b.getFullYear() < 0 ? 0 : 1];
                                    break;
                                case "e":
                                    e += b.getDate();
                                    break;
                                case "H":
                                    (d = b.getHours()), 10 > d && (e += "0"), (e += String(d));
                                    break;
                                case "h":
                                case "I":
                                    (d = b.getHours() % 12), 0 == d ? (e += "12") : (10 > d && (e += "0"), (e += String(d)));
                                    break;
                                case "i":
                                    (d = b.getMinutes()), 10 > d && (e += "0"), (e += String(d));
                                    break;
                                case "k":
                                    e += b.getHours();
                                    break;
                                case "l":
                                    (d = b.getHours() % 12), (e += 0 == d ? "12" : String(d));
                                    break;
                                case "M":
                                    e += this.mNames[b.getMonth()];
                                    break;
                                case "m":
                                    (d = b.getMonth() + 1), 10 > d && (e += "0"), (e += String(d));
                                    break;
                                case "p":
                                    e += b.getHours() < 12 ? "AM" : "PM";
                                    break;
                                case "r":
                                    (d = b.getHours() % 12),
                                        0 == d ? (e += "12:") : (10 > d && (e += "0"), (e += String(d) + ":")),
                                        (d = b.getMinutes()),
                                        10 > d && (e += "0"),
                                        (e += String(d) + ":"),
                                        (d = b.getSeconds()),
                                        10 > d && (e += "0"),
                                        (e += String(d)),
                                        (e += b.getHours() < 12 ? "AM" : "PM");
                                    break;
                                case "S":
                                case "s":
                                    (d = b.getSeconds()), 10 > d && (e += "0"), (e += String(d));
                                    break;
                                case "T":
                                    (d = b.getHours()), 10 > d && (e += "0"), (e += String(d) + ":"), (d = b.getMinutes()), 10 > d && (e += "0"), (e += String(d) + ":"), (d = b.getSeconds()), 10 > d && (e += "0"), (e += String(d));
                                    break;
                                case "W":
                                    e += this.dNames[b.getDay()];
                                    break;
                                case "w":
                                    e += b.getDay();
                                    break;
                                case "Y":
                                    e += AnyTime.pad(b.getFullYear(), 4);
                                    break;
                                case "y":
                                    (d = b.getFullYear() % 100), (e += AnyTime.pad(d, 2));
                                    break;
                                case "Z":
                                    e += AnyTime.pad(Math.abs(b.getFullYear()), 4);
                                    break;
                                case "z":
                                    e += Math.abs(b.getFullYear());
                                    break;
                                case "%":
                                    e += "%";
                                    break;
                                case "#":
                                    (d = h != Number.MIN_VALUE ? h : j == Number.MIN_VALUE ? 0 - b.getTimezoneOffset() : j), d >= 0 && (e += "+"), (e += d);
                                    break;
                                case "@":
                                    if (((d = h != Number.MIN_VALUE ? h : j == Number.MIN_VALUE ? 0 - b.getTimezoneOffset() : j), AnyTime.utcLabel && AnyTime.utcLabel[d])) {
                                        e += k > 0 && k < AnyTime.utcLabel[d].length ? AnyTime.utcLabel[d][k] : AnyTime.utcLabel[d][0];
                                        break;
                                    }
                                    (e += "UTC"), (g = ":");
                                case "+":
                                case "-":
                                case ":":
                                case ";":
                                    (d = h != Number.MIN_VALUE ? h : j == Number.MIN_VALUE ? 0 - b.getTimezoneOffset() : j),
                                        (e += 0 > d ? "-" : "+"),
                                        (d = Math.abs(d)),
                                        (e += "+" == g || ":" == g ? AnyTime.pad(Math.floor(d / 60), 2) : Math.floor(d / 60)),
                                        (":" == g || ";" == g) && (e += ":"),
                                        (e += AnyTime.pad(d % 60, 2));
                                    break;
                                case "f":
                                case "j":
                                case "U":
                                case "u":
                                case "V":
                                case "v":
                                case "X":
                                case "x":
                                    throw "%" + g + " not implemented by AnyTime.Converter";
                                default:
                                    e += this.fmt.substr(f, 2);
                            }
                            f++;
                        }
                    return e;
                }),
                (this.getUtcParseOffsetCaptured = function () {
                    return i;
                }),
                (this.getUtcParseOffsetSubIndex = function () {
                    return m;
                }),
                (this.parse = function (a) {
                    (i = l), (m = -1);
                    for (var b, h, j, k, o, p = 1, q = new Date(4, 0, 1, 0, 0, 0, 0), r = a.length, s = 0, t = 1, u = l, v = 0; c > v; v++)
                        if ("%" == this.fmt.charAt(v)) {
                            var w = this.fmt.charAt(v + 1);
                            switch (w) {
                                case "a":
                                    for (h = !1, k = 0; r > s + k; k++) {
                                        for (j = a.substr(s, k), b = 0; 12 > b; b++)
                                            if (this.dAbbr[b] == j) {
                                                (h = !0), (s += k);
                                                break;
                                            }
                                        if (h) break;
                                    }
                                    if (!h) throw "unknown weekday: " + a.substr(s);
                                    break;
                                case "B":
                                    (k = this.eAbbr[0].length), r >= s + k && a.substr(s, k) == this.eAbbr[0] && ((p = -1), (s += k));
                                    break;
                                case "b":
                                    for (h = !1, k = 0; r > s + k; k++) {
                                        for (j = a.substr(s, k), b = 0; 12 > b; b++)
                                            if (this.mAbbr[b] == j) {
                                                q.setMonth(b), (h = !0), (s += k);
                                                break;
                                            }
                                        if (h) break;
                                    }
                                    if (!h) throw "unknown month: " + a.substr(s);
                                    break;
                                case "C":
                                    (k = this.eAbbr[1].length), r >= s + k && a.substr(s, k) == this.eAbbr[1] && (s += k);
                                    break;
                                case "c":
                                    r > s + 1 && this.dAt(a, s + 1) ? (q.setMonth((Number(a.substr(s, 2)) - 1) % 12), (s += 2)) : (q.setMonth((Number(a.substr(s, 1)) - 1) % 12), s++);
                                    break;
                                case "D":
                                    r > s + 1 && this.dAt(a, s + 1) ? (q.setDate(Number(a.substr(s, 2))), (s += 4)) : (q.setDate(Number(a.substr(s, 1))), (s += 3));
                                    break;
                                case "d":
                                    q.setDate(Number(a.substr(s, 2))), (s += 2);
                                    break;
                                case "E":
                                    if (((k = this.eAbbr[0].length), r >= s + k && a.substr(s, k) == this.eAbbr[0])) (p = -1), (s += k);
                                    else {
                                        if (!(s + (k = this.eAbbr[1].length) <= r && a.substr(s, k) == this.eAbbr[1])) throw "unknown era: " + a.substr(s);
                                        s += k;
                                    }
                                    break;
                                case "e":
                                    r > s + 1 && this.dAt(a, s + 1) ? (q.setDate(Number(a.substr(s, 2))), (s += 2)) : (q.setDate(Number(a.substr(s, 1))), s++);
                                    break;
                                case "f":
                                    s += 6;
                                    break;
                                case "H":
                                    q.setHours(Number(a.substr(s, 2))), (s += 2);
                                    break;
                                case "h":
                                case "I":
                                    q.setHours(Number(a.substr(s, 2))), (s += 2);
                                    break;
                                case "i":
                                    q.setMinutes(Number(a.substr(s, 2))), (s += 2);
                                    break;
                                case "k":
                                    r > s + 1 && this.dAt(a, s + 1) ? (q.setHours(Number(a.substr(s, 2))), (s += 2)) : (q.setHours(Number(a.substr(s, 1))), s++);
                                    break;
                                case "l":
                                    r > s + 1 && this.dAt(a, s + 1) ? (q.setHours(Number(a.substr(s, 2))), (s += 2)) : (q.setHours(Number(a.substr(s, 1))), s++);
                                    break;
                                case "M":
                                    for (h = !1, k = g; r >= s + k && !(k > e); k++) {
                                        for (j = a.substr(s, k), b = 0; 12 > b; b++)
                                            if (this.mNames[b] == j) {
                                                q.setMonth(b), (h = !0), (s += k);
                                                break;
                                            }
                                        if (h) break;
                                    }
                                    break;
                                case "m":
                                    q.setMonth((Number(a.substr(s, 2)) - 1) % 12), (s += 2);
                                    break;
                                case "p":
                                    12 == q.getHours() ? "A" == a.charAt(s) && q.setHours(0) : "P" == a.charAt(s) && q.setHours(q.getHours() + 12), (s += 2);
                                    break;
                                case "r":
                                    q.setHours(Number(a.substr(s, 2))),
                                        q.setMinutes(Number(a.substr(s + 3, 2))),
                                        q.setSeconds(Number(a.substr(s + 6, 2))),
                                        12 == q.getHours() ? "A" == a.charAt(s + 8) && q.setHours(0) : "P" == a.charAt(s + 8) && q.setHours(q.getHours() + 12),
                                        (s += 10);
                                    break;
                                case "S":
                                case "s":
                                    q.setSeconds(Number(a.substr(s, 2))), (s += 2);
                                    break;
                                case "T":
                                    q.setHours(Number(a.substr(s, 2))), q.setMinutes(Number(a.substr(s + 3, 2))), q.setSeconds(Number(a.substr(s + 6, 2))), (s += 8);
                                    break;
                                case "W":
                                    for (h = !1, k = f; r >= s + k && !(k > d); k++) {
                                        for (j = a.substr(s, k), b = 0; 7 > b; b++)
                                            if (this.dNames[b] == j) {
                                                (h = !0), (s += k);
                                                break;
                                            }
                                        if (h) break;
                                    }
                                    break;
                                case "w":
                                    s += 1;
                                    break;
                                case "Y":
                                    (b = 4), "-" == a.substr(s, 1) && b++, q.setFullYear(Number(a.substr(s, b))), (s += b);
                                    break;
                                case "y":
                                    (b = 2), "-" == a.substr(s, 1) && b++, (o = Number(a.substr(s, b))), (o += "number" == typeof this.baseYear ? this.baseYear : 70 > o ? 2e3 : 1900), q.setFullYear(o), (s += b);
                                    break;
                                case "Z":
                                    q.setFullYear(Number(a.substr(s, 4))), (s += 4);
                                    break;
                                case "z":
                                    for (b = 0; r > s && this.dAt(a, s); ) b = 10 * b + Number(a.charAt(s++));
                                    q.setFullYear(b);
                                    break;
                                case "#":
                                    for ("-" == a.charAt(s++) && (t = -1), u = 0; r > s && String((b = Number(a.charAt(s)))) == a.charAt(s); s++) u = 10 * u + b;
                                    u *= t;
                                    break;
                                case "@":
                                    if (((m = -1), AnyTime.utcLabel)) {
                                        h = !1;
                                        for (u in AnyTime.utcLabel)
                                            if (!Array.prototype[u]) {
                                                for (b = 0; b < AnyTime.utcLabel[u].length; b++)
                                                    if (((j = AnyTime.utcLabel[u][b]), (k = j.length), r >= s + k && a.substr(s, k) == j)) {
                                                        (s += k), (h = !0);
                                                        break;
                                                    }
                                                if (h) break;
                                            }
                                        if (h) {
                                            (m = b), (u = Number(u));
                                            break;
                                        }
                                    }
                                    if (r > s + 9 || "UTC" != a.substr(s, 3)) throw "unknown time zone: " + a.substr(s);
                                    (s += 3), (w = ":");
                                case "-":
                                case "+":
                                case ":":
                                case ";":
                                    "-" == a.charAt(s++) && (t = -1),
                                        (u = Number(a.charAt(s))),
                                        ("+" == w || ":" == w || (r > s + 3 && String(Number(a.charAt(s + 3))) !== a.charAt(s + 3))) && (u = 10 * u + Number(a.charAt(++s))),
                                        (u *= 60),
                                        (":" == w || ";" == w) && s++,
                                        (u = (u + Number(a.substr(++s, 2))) * t),
                                        (s += 2);
                                    break;
                                case "j":
                                case "U":
                                case "u":
                                case "V":
                                case "v":
                                case "X":
                                case "x":
                                    throw "%" + this.fmt.charAt(v + 1) + " not implemented by AnyTime.Converter";
                                case "%":
                                default:
                                    throw "%" + this.fmt.charAt(v + 1) + " reserved for future use";
                            }
                            v++;
                        } else {
                            if (this.fmt.charAt(v) != a.charAt(s)) throw a + ' is not in "' + this.fmt + '" format';
                            s++;
                        }
                    return 0 > p && q.setFullYear(0 - q.getFullYear()), u != Number.MIN_VALUE && (n ? (i = u) : q.setTime(q.getTime() - 6e4 * u - 6e4 * q.getTimezoneOffset())), q;
                }),
                (this.setUtcFormatOffsetAlleged = function (a) {
                    var b = h;
                    return (h = a), b;
                }),
                (this.setUtcFormatOffsetSubIndex = function (a) {
                    var b = k;
                    return (k = a), b;
                }),
                (function (h) {
                    var i, k;
                    if (
                        ((b = jQuery.extend(!0, {}, b || {})),
                        b.baseYear && (h.baseYear = Number(b.baseYear)),
                        b.format && (h.fmt = b.format),
                        (c = h.fmt.length),
                        b.dayAbbreviations && (h.dAbbr = a.makeArray(b.dayAbbreviations)),
                        b.dayNames)
                    )
                        for (h.dNames = a.makeArray(b.dayNames), d = 1, f = 1e3, i = 0; 7 > i; i++) (k = h.dNames[i].length), k > d && (d = k), f > k && (f = k);
                    if ((b.eraAbbreviations && (h.eAbbr = a.makeArray(b.eraAbbreviations)), b.monthAbbreviations && (h.mAbbr = a.makeArray(b.monthAbbreviations)), b.monthNames))
                        for (h.mNames = a.makeArray(b.monthNames), e = 1, g = 1e3, i = 0; 12 > i; i++) (k = h.mNames[i].length), k > e && (e = k), g > k && (g = k);
                    "undefined" != typeof b.utcFormatOffsetImposed && (j = b.utcFormatOffsetImposed), "undefined" != typeof b.utcParseOffsetAssumed && (l = b.utcParseOffsetAssumed), b.utcParseOffsetCapture && (n = !0);
                })(this);
        }),
        (AnyTime.noPicker = function (a) {
            d[a] && (d[a].cleanup(), delete d[a]);
        }),
        (AnyTime.picker = function (e, f) {
            if (d[e]) throw 'Cannot create another AnyTime.picker for "' + e + '"';
            var g = null;
            (d[e] = {
                twelveHr: !1,
                ajaxOpts: null,
                denyTab: !0,
                askEra: !1,
                cloak: null,
                conv: null,
                div: null,
                dB: null,
                dD: null,
                dY: null,
                dMo: null,
                dDoM: null,
                hDoM: null,
                hMo: null,
                hTitle: null,
                hY: null,
                dT: null,
                dH: null,
                dM: null,
                dS: null,
                dO: null,
                earliest: null,
                fBtn: null,
                fDOW: 0,
                hBlur: null,
                hClick: null,
                hFocus: null,
                hKeydown: null,
                hResize: null,
                id: null,
                inp: null,
                latest: null,
                lastAjax: null,
                lostFocus: !1,
                lX: "X",
                lY: "Year",
                lO: "Time Zone",
                oBody: null,
                oConv: null,
                oCur: null,
                oDiv: null,
                oLab: null,
                oList: null,
                oSel: null,
                offMin: Number.MIN_VALUE,
                offSI: -1,
                offStr: "",
                pop: !0,
                ro: !1,
                time: null,
                url: null,
                yAhead: null,
                y0XXX: null,
                yCur: null,
                yDiv: null,
                yLab: null,
                yNext: null,
                yPast: null,
                yPrior: null,
                initialize: function (d) {
                    if (((g = this), (this.id = "AnyTime--" + d.replace(/[^-_.A-Za-z0-9]/g, "--AnyTime--")), (f = jQuery.extend(!0, {}, f || {})), (f.utcParseOffsetCapture = !0), (this.conv = new AnyTime.Converter(f)), f.placement))
                        if ("inline" == f.placement) this.pop = !1;
                        else if ("popup" != f.placement) throw "unknown placement: " + f.placement;
                    if (
                        (f.ajaxOptions &&
                            ((this.ajaxOpts = jQuery.extend({}, f.ajaxOptions)),
                            this.ajaxOpts.success ||
                                (this.ajaxOpts.success = function (a) {
                                    g.updVal(a);
                                })),
                        f.earliest && (this.earliest = this.makeDate(f.earliest)),
                        f.firstDOW)
                    ) {
                        if (f.firstDOW < 0 || f.firstDOW > 6) throw "illegal firstDOW: " + f.firstDOW;
                        this.fDOW = f.firstDOW;
                    }
                    f.latest && (this.latest = this.makeDate(f.latest)), (this.lX = f.labelDismiss || "X"), (this.lY = f.labelYear || "Year"), (this.lO = f.labelTimeZone || "Time Zone");
                    var e,
                        h,
                        i,
                        j = 0,
                        k = this.conv.fmt;
                    this.askEra = "undefined" != typeof f.askEra ? f.askEra : k.indexOf("%B") >= 0 || k.indexOf("%C") >= 0 || k.indexOf("%E") >= 0;
                    var l = k.indexOf("%Y") >= 0 || k.indexOf("%y") >= 0 || k.indexOf("%Z") >= 0 || k.indexOf("%z") >= 0,
                        m = k.indexOf("%b") >= 0 || k.indexOf("%c") >= 0 || k.indexOf("%M") >= 0 || k.indexOf("%m") >= 0,
                        n = k.indexOf("%D") >= 0 || k.indexOf("%d") >= 0 || k.indexOf("%e") >= 0,
                        o = l || m || n;
                    this.twelveHr = k.indexOf("%h") >= 0 || k.indexOf("%I") >= 0 || k.indexOf("%l") >= 0 || k.indexOf("%r") >= 0;
                    var p = this.twelveHr || k.indexOf("%H") >= 0 || k.indexOf("%k") >= 0 || k.indexOf("%T") >= 0,
                        q = k.indexOf("%i") >= 0 || k.indexOf("%r") >= 0 || k.indexOf("%T") >= 0,
                        r = k.indexOf("%r") >= 0 || k.indexOf("%S") >= 0 || k.indexOf("%s") >= 0 || k.indexOf("%T") >= 0;
                    r && "undefined" != typeof f.askSecond && (r = f.askSecond);
                    var s = k.indexOf("%#") >= 0 || k.indexOf("%+") >= 0 || k.indexOf("%-") >= 0 || k.indexOf("%:") >= 0 || k.indexOf("%;") >= 0 || k.indexOf("%<") >= 0 || k.indexOf("%>") >= 0 || k.indexOf("%@") >= 0,
                        t = p || q || r || s;
                    s && (this.oConv = new AnyTime.Converter({ format: f.formatUtcOffset || k.match(/\S*%[-+:;<>#@]\S*/g).join(" ") })),
                        (this.inp = a(document.getElementById(d))),
                        (this.ro = this.inp.prop("readonly")),
                        this.inp.prop("readonly", !0),
                        (this.div = a('<div class="AnyTime-win AnyTime-pkr ui-widget ui-widget-content ui-corner-all" id="' + this.id + '" aria-live="off"></div>')),
                        this.inp.after(this.div),
                        (this.hTitle = a('<h5 class="AnyTime-hdr ui-widget-header ui-corner-top"/>')),
                        this.div.append(this.hTitle),
                        (this.dB = a('<div class="AnyTime-body"></div>')),
                        this.div.append(this.dB),
                        f.hideInput && this.inp.css({ border: 0, height: "1px", margin: 0, padding: 0, width: "1px" }),
                        (h = null);
                    var u = null;
                    if (
                        (this.pop &&
                            ((u = a('<div class="AnyTime-x-btn ui-state-default">' + this.lX + "</div>")),
                            this.hTitle.append(u),
                            u.click(function (a) {
                                g.dismiss(a);
                            })),
                        (i = ""),
                        o)
                    ) {
                        if (
                            ((this.dD = a('<div class="AnyTime-date"></div>')),
                            this.dB.append(this.dD),
                            l &&
                                ((this.yLab = a('<h6 class="AnyTime-lbl AnyTime-lbl-yr">' + this.lY + "</h6>")),
                                this.dD.append(this.yLab),
                                (this.dY = a('<ul class="AnyTime-yrs ui-helper-reset" />')),
                                this.dD.append(this.dY),
                                (this.yPast = this.btn(this.dY, "&lt;", this.newYear, ["yrs-past"], "- " + this.lY)),
                                (this.yPrior = this.btn(this.dY, "1", this.newYear, ["yr-prior"], "-1 " + this.lY)),
                                (this.yCur = this.btn(this.dY, "2", this.newYear, ["yr-cur"], this.lY)),
                                this.yCur.removeClass("ui-state-default"),
                                this.yCur.addClass("AnyTime-cur-btn ui-state-default ui-state-active"),
                                (this.yNext = this.btn(this.dY, "3", this.newYear, ["yr-next"], "+1 " + this.lY)),
                                (this.yAhead = this.btn(this.dY, "&gt;", this.newYear, ["yrs-ahead"], "+ " + this.lY)),
                                j++),
                            m)
                        ) {
                            for (
                                i = f.labelMonth || "Month", this.hMo = a('<h6 class="AnyTime-lbl AnyTime-lbl-month">' + i + "</h6>"), this.dD.append(this.hMo), this.dMo = a('<ul class="AnyTime-mons" />'), this.dD.append(this.dMo), e = 0;
                                12 > e;
                                e++
                            ) {
                                var v = this.btn(
                                    this.dMo,
                                    this.conv.mAbbr[e],
                                    function (c) {
                                        var d = a(c.target);
                                        if (!d.hasClass("AnyTime-out-btn")) {
                                            var e = c.target.AnyTime_month,
                                                f = new Date(this.time.getTime());
                                            f.getDate() > b[e] && f.setDate(b[e]), f.setMonth(e), this.set(f), this.upd(d);
                                        }
                                    },
                                    ["mon", "mon" + String(e + 1)],
                                    i + " " + this.conv.mNames[e]
                                );
                                v[0].AnyTime_month = e;
                            }
                            j++;
                        }
                        if (n) {
                            (i = f.labelDayOfMonth || "Day of Month"),
                                (this.hDoM = a('<h6 class="AnyTime-lbl AnyTime-lbl-dom">' + i + "</h6>")),
                                this.dD.append(this.hDoM),
                                (this.dDoM = a('<table border="0" cellpadding="0" cellspacing="0" class="AnyTime-dom-table"/>')),
                                this.dD.append(this.dDoM),
                                (h = a('<thead class="AnyTime-dom-head"/>')),
                                this.dDoM.append(h);
                            var w = a('<tr class="AnyTime-dow"/>');
                            for (h.append(w), e = 0; 7 > e; e++) w.append('<th class="AnyTime-dow AnyTime-dow' + String(e + 1) + '">' + this.conv.dAbbr[(this.fDOW + e) % 7] + "</th>");
                            var x = a('<tbody class="AnyTime-dom-body" />');
                            this.dDoM.append(x);
                            for (var y = 0; 6 > y; y++)
                                for (w = a('<tr class="AnyTime-wk AnyTime-wk' + String(y + 1) + '"/>'), x.append(w), e = 0; 7 > e; e++)
                                    this.btn(
                                        w,
                                        "x",
                                        function (b) {
                                            var c = a(b.target);
                                            if (!c.hasClass("AnyTime-out-btn")) {
                                                var d = Number(c.html());
                                                if (d) {
                                                    var e = new Date(this.time.getTime());
                                                    e.setDate(d), this.set(e), this.upd(c);
                                                }
                                            }
                                        },
                                        ["dom"],
                                        i
                                    );
                            j++;
                        }
                    }
                    if (t) {
                        var z, A;
                        if (((this.dT = a('<div class="AnyTime-time"></div>')), this.dB.append(this.dT), p)) {
                            (this.dH = a('<div class="AnyTime-hrs"></div>')), this.dT.append(this.dH), (i = f.labelHour || "Hour"), this.dH.append(a('<h6 class="AnyTime-lbl AnyTime-lbl-hr">' + i + "</h6>"));
                            var B = a('<ul class="AnyTime-hrs-am"/>');
                            this.dH.append(B);
                            var C = a('<ul class="AnyTime-hrs-pm"/>');
                            for (this.dH.append(C), e = 0; 12 > e; e++)
                                (h = this.twelveHr ? (0 == e ? "12am" : String(e) + "am") : AnyTime.pad(e, 2)),
                                    this.btn(B, h, this.newHour, ["hr", "hr" + String(e)], i + " " + h),
                                    (h = this.twelveHr ? (0 == e ? "12pm" : String(e) + "pm") : e + 12),
                                    this.btn(C, h, this.newHour, ["hr", "hr" + String(e + 12)], i + " " + h);
                            j++;
                        }
                        if (q) {
                            for (
                                this.dM = a('<div class="AnyTime-mins"></div>'),
                                    this.dT.append(this.dM),
                                    i = f.labelMinute || "Minute",
                                    this.dM.append(a('<h6 class="AnyTime-lbl AnyTime-lbl-min">' + i + "</h6>")),
                                    z = a('<ul class="AnyTime-mins-tens"/>'),
                                    this.dM.append(z),
                                    e = 0;
                                6 > e;
                                e++
                            )
                                this.btn(
                                    z,
                                    e,
                                    function (b) {
                                        var c = a(b.target);
                                        if (!c.hasClass("AnyTime-out-btn")) {
                                            var d = new Date(this.time.getTime());
                                            d.setMinutes(10 * Number(c.text()) + (this.time.getMinutes() % 10)), this.set(d), this.upd(c);
                                        }
                                    },
                                    ["min-ten", "min" + e + "0"],
                                    i + " " + e + "0"
                                );
                            for (; 12 > e; e++) this.btn(z, "&#160;", a.noop, ["min-ten", "min" + e + "0"], i + " " + e + "0").addClass("AnyTime-min-ten-btn-empty ui-state-default ui-state-disabled");
                            for (A = a('<ul class="AnyTime-mins-ones"/>'), this.dM.append(A), e = 0; 10 > e; e++)
                                this.btn(
                                    A,
                                    e,
                                    function (b) {
                                        var c = a(b.target);
                                        if (!c.hasClass("AnyTime-out-btn")) {
                                            var d = new Date(this.time.getTime());
                                            d.setMinutes(10 * Math.floor(this.time.getMinutes() / 10) + Number(c.text())), this.set(d), this.upd(c);
                                        }
                                    },
                                    ["min-one", "min" + e],
                                    i + " " + e
                                );
                            for (; 12 > e; e++) this.btn(A, "&#160;", a.noop, ["min-one", "min" + e + "0"], i + " " + e).addClass("AnyTime-min-one-btn-empty ui-state-default ui-state-disabled");
                            j++;
                        }
                        if (r) {
                            for (
                                this.dS = a('<div class="AnyTime-secs"></div>'),
                                    this.dT.append(this.dS),
                                    i = f.labelSecond || "Second",
                                    this.dS.append(a('<h6 class="AnyTime-lbl AnyTime-lbl-sec">' + i + "</h6>")),
                                    z = a('<ul class="AnyTime-secs-tens"/>'),
                                    this.dS.append(z),
                                    e = 0;
                                6 > e;
                                e++
                            )
                                this.btn(
                                    z,
                                    e,
                                    function (b) {
                                        var c = a(b.target);
                                        if (!c.hasClass("AnyTime-out-btn")) {
                                            var d = new Date(this.time.getTime());
                                            d.setSeconds(10 * Number(c.text()) + (this.time.getSeconds() % 10)), this.set(d), this.upd(c);
                                        }
                                    },
                                    ["sec-ten", "sec" + e + "0"],
                                    i + " " + e + "0"
                                );
                            for (; 12 > e; e++) this.btn(z, "&#160;", a.noop, ["sec-ten", "sec" + e + "0"], i + " " + e + "0").addClass("AnyTime-sec-ten-btn-empty ui-state-default ui-state-disabled");
                            for (A = a('<ul class="AnyTime-secs-ones"/>'), this.dS.append(A), e = 0; 10 > e; e++)
                                this.btn(
                                    A,
                                    e,
                                    function (b) {
                                        var c = a(b.target);
                                        if (!c.hasClass("AnyTime-out-btn")) {
                                            var d = new Date(this.time.getTime());
                                            d.setSeconds(10 * Math.floor(this.time.getSeconds() / 10) + Number(c.text())), this.set(d), this.upd(c);
                                        }
                                    },
                                    ["sec-one", "sec" + e],
                                    i + " " + e
                                );
                            for (; 12 > e; e++) this.btn(A, "&#160;", a.noop, ["sec-one", "sec" + e + "0"], i + " " + e).addClass("AnyTime-sec-one-btn-empty ui-state-default ui-state-disabled");
                            j++;
                        }
                        s &&
                            ((this.dO = a('<div class="AnyTime-offs" ></div>')),
                            this.dT.append("<br />"),
                            this.dT.append(this.dO),
                            (this.oList = a('<ul class="AnyTime-off-list ui-helper-reset" />')),
                            this.dO.append(this.oList),
                            (this.oCur = this.btn(this.oList, "", this.newOffset, ["off", "off-cur"], i)),
                            this.oCur.removeClass("ui-state-default"),
                            this.oCur.addClass("AnyTime-cur-btn ui-state-default ui-state-active"),
                            (this.oSel = this.btn(this.oList, "&#177;", this.newOffset, ["off", "off-select"], "+/- " + this.lO)),
                            (this.oMinW = this.dO.outerWidth(!0)),
                            (this.oLab = a('<h6 class="AnyTime-lbl AnyTime-lbl-off">' + this.lO + "</h6>")),
                            this.dO.prepend(this.oLab),
                            j++);
                    }
                    f.labelTitle ? this.hTitle.append(f.labelTitle) : j > 1 ? this.hTitle.append("Select a " + (o ? (t ? "Date and Time" : "Date") : "Time")) : this.hTitle.append("Select");
                    try {
                        (this.time = this.conv.parse(this.inp.val())), (this.offMin = this.conv.getUtcParseOffsetCaptured()), (this.offSI = this.conv.getUtcParseOffsetSubIndex()), "init" in f && (this.time = this.makeDate(f.init));
                    } catch (D) {
                        this.time = new Date();
                    }
                    (this.lastAjax = this.time),
                        this.pop && (this.div.hide(), this.div.css("position", "absolute")),
                        this.inp.blur(
                            (this.hBlur = function (a) {
                                g.inpBlur(a);
                            })
                        ),
                        this.inp.click(
                            (this.hClick = function (a) {
                                g.showPkr(a);
                            })
                        ),
                        this.inp.focus(
                            (this.hFocus = function (a) {
                                g.lostFocus && g.showPkr(a), (g.lostFocus = !1);
                            })
                        ),
                        this.inp.keydown(
                            (this.hKeydown = function (a) {
                                g.key(a);
                            })
                        ),
                        this.div.click(function () {
                            (g.lostFocus = !1), g.inp.focus();
                        }),
                        a(window).resize(
                            (this.hResize = function (a) {
                                g.pos(a);
                            })
                        ),
                        c && this.onReady();
                },
                ajax: function () {
                    if (this.ajaxOpts && this.time.getTime() != this.lastAjax.getTime())
                        try {
                            var b = jQuery.extend({}, this.ajaxOpts);
                            if ("object" == typeof b.data) b.data[this.inp[0].name || this.inp[0].id] = this.inp.val();
                            else {
                                var c = (this.inp[0].name || this.inp[0].id) + "=" + encodeURI(this.inp.val());
                                b.data ? (b.data += "&" + c) : (b.data = c);
                            }
                            a.ajax(b), (this.lastAjax = this.time);
                        } catch (d) {}
                },
                askOffset: function (b) {
                    if (this.oDiv) this.cloak.show(), this.oDiv.show();
                    else {
                        this.makeCloak(), (this.oDiv = a('<div class="AnyTime-win AnyTime-off-selector ui-widget ui-widget-content ui-corner-all"></div>')), this.div.append(this.oDiv);
                        var c = a('<h5 class="AnyTime-hdr AnyTime-hdr-off-selector ui-widget-header ui-corner-top" />');
                        this.oDiv.append(c), (this.oBody = a('<div class="AnyTime-body AnyTime-body-off-selector"></div>')), this.oDiv.append(this.oBody);
                        var d = a('<div class="AnyTime-x-btn ui-state-default">' + this.lX + "</div>");
                        c.append(d),
                            d.click(function (a) {
                                g.dismissODiv(a);
                            }),
                            c.append(this.lO);
                        var e = a('<ul class="AnyTime-off-off" />'),
                            f = null;
                        this.oBody.append(e);
                        var h = this.oConv.fmt.indexOf("%@") >= 0;
                        if (AnyTime.utcLabel)
                            for (var i = -720; 840 >= i; i++)
                                if (AnyTime.utcLabel[i]) {
                                    this.oConv.setUtcFormatOffsetAlleged(i);
                                    for (
                                        var j = 0;
                                        j < AnyTime.utcLabel[i].length &&
                                        (this.oConv.setUtcFormatOffsetSubIndex(j), (f = this.btn(e, this.oConv.format(this.time), this.newOPos, ["off-off"], i)), (f[0].AnyTime_offMin = i), (f[0].AnyTime_offSI = j), h);
                                        j++
                                    );
                                }
                        if ((f && f.addClass("AnyTime-off-off-last-btn"), this.oDiv.outerHeight(!0) > this.div.height())) {
                            var k = this.oBody.width();
                            this.oBody.css("height", "0"), this.oBody.css({ height: String(this.div.height() - (this.oDiv.outerHeight(!0) + this.oBody.outerHeight(!1))) + "px", width: String(k + 20) + "px" });
                        }
                        this.oDiv.outerWidth(!0) > this.div.width() && (this.oBody.css("width", "0"), this.oBody.css("width", String(this.div.width() - (this.oDiv.outerWidth(!0) + this.oBody.outerWidth(!1))) + "px"));
                    }
                    this.pos(b), this.updODiv(null);
                    var l = this.oDiv.find(".AnyTime-off-off-btn.AnyTime-cur-btn:first");
                    l.length || (l = this.oDiv.find(".AnyTime-off-off-btn:first")), this.setFocus(l);
                },
                askYear: function (b) {
                    if (this.yDiv) this.cloak.show(), this.yDiv.show();
                    else {
                        this.makeCloak(), (this.yDiv = a('<div class="AnyTime-win AnyTime-yr-selector ui-widget ui-widget-content ui-corner-all"></div>')), this.div.append(this.yDiv);
                        var c = a('<h5 class="AnyTime-hdr AnyTime-hdr-yr-selector ui-widget-header ui-corner-top" />');
                        this.yDiv.append(c);
                        var d = a('<div class="AnyTime-x-btn ui-state-default">' + this.lX + "</div>");
                        c.append(d),
                            d.click(function (a) {
                                g.dismissYDiv(a);
                            }),
                            c.append(this.lY);
                        var e = a('<div class="AnyTime-body AnyTime-body-yr-selector" ></div>');
                        for (this.yDiv.append(e), cont = a('<ul class="AnyTime-yr-mil" />'), e.append(cont), this.y0XXX = this.btn(cont, 0, this.newYPos, ["mil", "mil0"], this.lY + " 0000"), i = 1; 10 > i; i++)
                            this.btn(cont, i, this.newYPos, ["mil", "mil" + i], this.lY + " " + i + "000");
                        for (cont = a('<ul class="AnyTime-yr-cent" />'), e.append(cont), i = 0; 10 > i; i++) this.btn(cont, i, this.newYPos, ["cent", "cent" + i], this.lY + " " + i + "00");
                        for (cont = a('<ul class="AnyTime-yr-dec" />'), e.append(cont), i = 0; 10 > i; i++) this.btn(cont, i, this.newYPos, ["dec", "dec" + i], this.lY + " " + i + "0");
                        for (cont = a('<ul class="AnyTime-yr-yr" />'), e.append(cont), i = 0; 10 > i; i++) this.btn(cont, i, this.newYPos, ["yr", "yr" + i], this.lY + " " + i);
                        this.askEra &&
                            ((cont = a('<ul class="AnyTime-yr-era" />')),
                            e.append(cont),
                            this.btn(
                                cont,
                                this.conv.eAbbr[0],
                                function (b) {
                                    var c = new Date(this.time.getTime()),
                                        d = c.getFullYear();
                                    d > 0 && c.setFullYear(0 - d), this.set(c), this.updYDiv(a(b.target));
                                },
                                ["era", "bce"],
                                this.conv.eAbbr[0]
                            ),
                            this.btn(
                                cont,
                                this.conv.eAbbr[1],
                                function (b) {
                                    var c = new Date(this.time.getTime()),
                                        d = c.getFullYear();
                                    0 > d && c.setFullYear(0 - d), this.set(c), this.updYDiv(a(b.target));
                                },
                                ["era", "ce"],
                                this.conv.eAbbr[1]
                            ));
                    }
                    this.pos(b), this.updYDiv(null), this.setFocus(this.yDiv.find(".AnyTime-yr-btn.AnyTime-cur-btn:first"));
                },
                inpBlur: function (a) {
                    return this.oDiv && this.oDiv.is(":visible")
                        ? (g.inp.focus(), void 0)
                        : ((this.lostFocus = !0),
                          setTimeout(function () {
                              g.lostFocus && (g.div.find(".AnyTime-focus-btn").removeClass("AnyTime-focus-btn ui-state-focus"), g.pop ? g.dismiss(a) : g.ajax());
                          }, 334),
                          void 0);
                },
                btn: function (b, c, d, e, f) {
                    for (var h = "ul" == b[0].nodeName.toLowerCase() ? "li" : "td", i = "<" + h + ' class="AnyTime-btn', j = 0; j < e.length; j++) i += " AnyTime-" + e[j] + "-btn";
                    var k = a(i + ' ui-state-default">' + c + "</" + h + ">");
                    return (
                        b.append(k),
                        (k.AnyTime_title = f),
                        k.click(function (a) {
                            (g.tempFunc = d), g.tempFunc(a);
                        }),
                        k.dblclick(function (b) {
                            var c = a(this);
                            c.is(".AnyTime-off-off-btn")
                                ? g.dismissODiv(b)
                                : c.is(".AnyTime-mil-btn") || c.is(".AnyTime-cent-btn") || c.is(".AnyTime-dec-btn") || c.is(".AnyTime-yr-btn") || c.is(".AnyTime-era-btn")
                                ? g.dismissYDiv(b)
                                : g.pop && g.dismiss(b);
                        }),
                        k
                    );
                },
                cleanup: function () {
                    this.inp.prop("readonly", this.ro).off("blur", this.hBlur).off("click", this.hClick).off("focus", this.hFocus).off("keydown", this.hKeydown), a(window).off("resize", this.hResize), this.div.remove();
                },
                dismiss: function () {
                    this.ajax(), this.yDiv && this.dismissYDiv(), this.oDiv && this.dismissODiv(), this.div.hide(), (this.lostFocus = !0);
                },
                dismissODiv: function () {
                    this.oDiv.hide(), this.cloak.hide(), this.setFocus(this.oCur);
                },
                dismissYDiv: function () {
                    this.yDiv.hide(), this.cloak.hide(), this.setFocus(this.yCur);
                },
                setFocus: function (a) {
                    if (
                        (a.hasClass("AnyTime-focus-btn") ||
                            (this.div.find(".AnyTime-focus-btn").removeClass("AnyTime-focus-btn ui-state-focus"),
                            (this.fBtn = a),
                            a.removeClass("ui-state-default ui-state-active"),
                            a.addClass("AnyTime-focus-btn ui-state-default ui-state-active ui-state-focus")),
                        a.hasClass("AnyTime-off-off-btn"))
                    ) {
                        var b = this.oBody.offset().top,
                            c = a.offset().top,
                            d = a.outerHeight(!0);
                        b > c - d ? this.oBody.scrollTop(c + this.oBody.scrollTop() - (this.oBody.innerHeight() + b) + 2 * d) : c + d > b + this.oBody.innerHeight() && this.oBody.scrollTop(c + this.oBody.scrollTop() - (b + d));
                    }
                },
                key: function (a) {
                    var c,
                        d = null,
                        e = this,
                        f = (this.div.find(".AnyTime-focus-btn"), a.keyCode || a.which);
                    if (((this.denyTab = !0), 16 == f));
                    else if (10 == f || 13 == f || 27 == f) this.oDiv && this.oDiv.is(":visible") ? this.dismissODiv(a) : this.yDiv && this.yDiv.is(":visible") ? this.dismissYDiv(a) : this.pop && this.dismiss(a);
                    else if (33 == f || (9 == f && a.shiftKey)) {
                        if (this.fBtn.hasClass("AnyTime-off-off-btn")) 9 == f && this.dismissODiv(a);
                        else if (this.fBtn.hasClass("AnyTime-mil-btn")) 9 == f && this.dismissYDiv(a);
                        else if (this.fBtn.hasClass("AnyTime-cent-btn")) this.yDiv.find(".AnyTime-mil-btn.AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-dec-btn")) this.yDiv.find(".AnyTime-cent-btn.AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-yr-btn")) this.yDiv.find(".AnyTime-dec-btn.AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-era-btn")) this.yDiv.find(".AnyTime-yr-btn.AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.parents(".AnyTime-yrs").length) {
                            if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-mon-btn")) {
                            if (this.dY) this.yCur.triggerHandler("click");
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-dom-btn")) {
                            if (9 == f && a.shiftKey) return (this.denyTab = !1), void 0;
                            (d = new Date(this.time.getTime())), a.shiftKey ? d.setFullYear(d.getFullYear() - 1) : ((c = d.getMonth() - 1), d.getDate() > b[c] && d.setDate(b[c]), d.setMonth(c)), this.keyDateChange(d);
                        } else if (this.fBtn.hasClass("AnyTime-hr-btn")) {
                            if ((d = this.dDoM || this.dMo)) d.AnyTime_clickCurrent();
                            else if (this.dY) this.yCur.triggerHandler("click");
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-min-ten-btn")) {
                            if ((d = this.dH || this.dDoM || this.dMo)) d.AnyTime_clickCurrent();
                            else if (this.dY) this.yCur.triggerHandler("click");
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-min-one-btn")) this.dM.AnyTime_clickCurrent();
                        else if (this.fBtn.hasClass("AnyTime-sec-ten-btn")) {
                            if ((d = this.dM ? this.dM.find(".AnyTime-mins-ones") : this.dH || this.dDoM || this.dMo)) d.AnyTime_clickCurrent();
                            else if (this.dY) this.yCur.triggerHandler("click");
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-sec-one-btn")) this.dS.AnyTime_clickCurrent();
                        else if (this.fBtn.hasClass("AnyTime-off-btn"))
                            if ((d = this.dS ? this.dS.find(".AnyTime-secs-ones") : this.dM ? this.dM.find(".AnyTime-mins-ones") : this.dH || this.dDoM || this.dMo)) d.AnyTime_clickCurrent();
                            else if (this.dY) this.yCur.triggerHandler("click");
                            else if (9 == f) return (this.denyTab = !1), void 0;
                    } else if (34 == f || 9 == f) {
                        if (this.fBtn.hasClass("AnyTime-mil-btn")) this.yDiv.find(".AnyTime-cent-btn.AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-cent-btn")) this.yDiv.find(".AnyTime-dec-btn.AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-dec-btn")) this.yDiv.find(".AnyTime-yr-btn.AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-yr-btn")) (d = this.yDiv.find(".AnyTime-era-btn.AnyTime-cur-btn")), d.length ? d.triggerHandler("click") : 9 == f && this.dismissYDiv(a);
                        else if (this.fBtn.hasClass("AnyTime-era-btn")) 9 == f && this.dismissYDiv(a);
                        else if (this.fBtn.hasClass("AnyTime-off-off-btn")) 9 == f && this.dismissODiv(a);
                        else if (this.fBtn.parents(".AnyTime-yrs").length) {
                            if ((d = this.dDoM || this.dMo || this.dH || this.dM || this.dS || this.dO)) d.AnyTime_clickCurrent();
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-mon-btn")) {
                            if ((d = this.dDoM || this.dH || this.dM || this.dS || this.dO)) d.AnyTime_clickCurrent();
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-dom-btn"))
                            if (9 == f) {
                                if (((d = this.dH || this.dM || this.dS || this.dO), !d)) return (this.denyTab = !1), void 0;
                                d.AnyTime_clickCurrent();
                            } else (d = new Date(this.time.getTime())), a.shiftKey ? d.setFullYear(d.getFullYear() + 1) : ((c = d.getMonth() + 1), d.getDate() > b[c] && d.setDate(b[c]), d.setMonth(c)), this.keyDateChange(d);
                        else if (this.fBtn.hasClass("AnyTime-hr-btn")) {
                            if ((d = this.dM || this.dS || this.dO)) d.AnyTime_clickCurrent();
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-min-ten-btn")) this.dM.find(".AnyTime-mins-ones .AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-min-one-btn")) {
                            if ((d = this.dS || this.dO)) d.AnyTime_clickCurrent();
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-sec-ten-btn")) this.dS.find(".AnyTime-secs-ones .AnyTime-cur-btn").triggerHandler("click");
                        else if (this.fBtn.hasClass("AnyTime-sec-one-btn")) {
                            if (this.dO) this.dO.AnyTime_clickCurrent();
                            else if (9 == f) return (this.denyTab = !1), void 0;
                        } else if (this.fBtn.hasClass("AnyTime-off-btn") && 9 == f) return (this.denyTab = !1), void 0;
                    } else if (35 == f)
                        this.fBtn.hasClass("AnyTime-mil-btn") || this.fBtn.hasClass("AnyTime-cent-btn") || this.fBtn.hasClass("AnyTime-dec-btn") || this.fBtn.hasClass("AnyTime-yr-btn") || this.fBtn.hasClass("AnyTime-era-btn")
                            ? ((d = this.yDiv.find(".AnyTime-ce-btn")), d.length || (d = this.yDiv.find(".AnyTime-yr9-btn")), d.triggerHandler("click"))
                            : this.fBtn.hasClass("AnyTime-dom-btn")
                            ? ((d = new Date(this.time.getTime())), d.setDate(1), d.setMonth(d.getMonth() + 1), d.setDate(d.getDate() - 1), a.ctrlKey && d.setMonth(11), this.keyDateChange(d))
                            : this.dS
                            ? this.dS.find(".AnyTime-sec9-btn").triggerHandler("click")
                            : this.dM
                            ? this.dM.find(".AnyTime-min9-btn").triggerHandler("click")
                            : this.dH
                            ? this.dH.find(".AnyTime-hr23-btn").triggerHandler("click")
                            : this.dDoM
                            ? this.dDoM.find(".AnyTime-dom-btn-filled:last").triggerHandler("click")
                            : this.dMo
                            ? this.dMo.find(".AnyTime-mon12-btn").triggerHandler("click")
                            : this.dY && this.yAhead.triggerHandler("click");
                    else if (36 == f)
                        this.fBtn.hasClass("AnyTime-mil-btn") || this.fBtn.hasClass("AnyTime-cent-btn") || this.fBtn.hasClass("AnyTime-dec-btn") || this.fBtn.hasClass("AnyTime-yr-btn") || this.fBtn.hasClass("AnyTime-era-btn")
                            ? this.yDiv.find(".AnyTime-mil0-btn").triggerHandler("click")
                            : this.fBtn.hasClass("AnyTime-dom-btn")
                            ? ((d = new Date(this.time.getTime())), d.setDate(1), a.ctrlKey && d.setMonth(0), this.keyDateChange(d))
                            : this.dY
                            ? this.yCur.triggerHandler("click")
                            : this.dMo
                            ? this.dMo.find(".AnyTime-mon1-btn").triggerHandler("click")
                            : this.dDoM
                            ? this.dDoM.find(".AnyTime-dom-btn-filled:first").triggerHandler("click")
                            : this.dH
                            ? this.dH.find(".AnyTime-hr0-btn").triggerHandler("click")
                            : this.dM
                            ? this.dM.find(".AnyTime-min00-btn").triggerHandler("click")
                            : this.dS && this.dS.find(".AnyTime-sec00-btn").triggerHandler("click");
                    else if (37 == f) this.fBtn.hasClass("AnyTime-dom-btn") ? ((d = new Date(this.time.getTime())), d.setDate(d.getDate() - 1), this.keyDateChange(d)) : this.keyBack();
                    else if (38 == f) this.fBtn.hasClass("AnyTime-dom-btn") ? ((d = new Date(this.time.getTime())), d.setDate(d.getDate() - 7), this.keyDateChange(d)) : this.keyBack();
                    else if (39 == f) this.fBtn.hasClass("AnyTime-dom-btn") ? ((d = new Date(this.time.getTime())), d.setDate(d.getDate() + 1), this.keyDateChange(d)) : this.keyAhead();
                    else if (40 == f) this.fBtn.hasClass("AnyTime-dom-btn") ? ((d = new Date(this.time.getTime())), d.setDate(d.getDate() + 7), this.keyDateChange(d)) : this.keyAhead();
                    else {
                        if ((86 == f || 118 == f) && a.ctrlKey)
                            return (
                                this.updVal(""),
                                setTimeout(function () {
                                    e.showPkr(null);
                                }, 100),
                                void 0
                            );
                        this.showPkr(null);
                    }
                    a.preventDefault();
                },
                keyAhead: function () {
                    this.fBtn.hasClass("AnyTime-mil9-btn")
                        ? this.yDiv.find(".AnyTime-cent0-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-cent9-btn")
                        ? this.yDiv.find(".AnyTime-dec0-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-dec9-btn")
                        ? this.yDiv.find(".AnyTime-yr0-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-yr9-btn")
                        ? this.yDiv.find(".AnyTime-bce-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-sec9-btn") ||
                          (this.fBtn.hasClass("AnyTime-sec50-btn")
                              ? this.dS.find(".AnyTime-sec0-btn").triggerHandler("click")
                              : this.fBtn.hasClass("AnyTime-min9-btn")
                              ? this.dS && this.dS.find(".AnyTime-sec00-btn").triggerHandler("click")
                              : this.fBtn.hasClass("AnyTime-min50-btn")
                              ? this.dM.find(".AnyTime-min0-btn").triggerHandler("click")
                              : this.fBtn.hasClass("AnyTime-hr23-btn")
                              ? this.dM
                                  ? this.dM.find(".AnyTime-min00-btn").triggerHandler("click")
                                  : this.dS && this.dS.find(".AnyTime-sec00-btn").triggerHandler("click")
                              : this.fBtn.hasClass("AnyTime-hr11-btn")
                              ? this.dH.find(".AnyTime-hr12-btn").triggerHandler("click")
                              : this.fBtn.hasClass("AnyTime-mon12-btn")
                              ? this.dDoM
                                  ? this.dDoM.AnyTime_clickCurrent()
                                  : this.dH
                                  ? this.dH.find(".AnyTime-hr0-btn").triggerHandler("click")
                                  : this.dM
                                  ? this.dM.find(".AnyTime-min00-btn").triggerHandler("click")
                                  : this.dS && this.dS.find(".AnyTime-sec00-btn").triggerHandler("click")
                              : this.fBtn.hasClass("AnyTime-yrs-ahead-btn")
                              ? this.dMo
                                  ? this.dMo.find(".AnyTime-mon1-btn").triggerHandler("click")
                                  : this.dH
                                  ? this.dH.find(".AnyTime-hr0-btn").triggerHandler("click")
                                  : this.dM
                                  ? this.dM.find(".AnyTime-min00-btn").triggerHandler("click")
                                  : this.dS && this.dS.find(".AnyTime-sec00-btn").triggerHandler("click")
                              : this.fBtn.hasClass("AnyTime-yr-cur-btn")
                              ? this.yNext.triggerHandler("click")
                              : this.fBtn.next().triggerHandler("click"));
                },
                keyBack: function () {
                    this.fBtn.hasClass("AnyTime-cent0-btn")
                        ? this.yDiv.find(".AnyTime-mil9-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-dec0-btn")
                        ? this.yDiv.find(".AnyTime-cent9-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-yr0-btn")
                        ? this.yDiv.find(".AnyTime-dec9-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-bce-btn")
                        ? this.yDiv.find(".AnyTime-yr9-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-yr-cur-btn")
                        ? this.yPrior.triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-mon1-btn")
                        ? this.dY && this.yCur.triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-hr0-btn")
                        ? this.dDoM
                            ? this.dDoM.AnyTime_clickCurrent()
                            : this.dMo
                            ? this.dMo.find(".AnyTime-mon12-btn").triggerHandler("click")
                            : this.dY && this.yNext.triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-hr12-btn")
                        ? this.dH.find(".AnyTime-hr11-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-min00-btn")
                        ? this.dH
                            ? this.dH.find(".AnyTime-hr23-btn").triggerHandler("click")
                            : this.dDoM
                            ? this.dDoM.AnyTime_clickCurrent()
                            : this.dMo
                            ? this.dMo.find(".AnyTime-mon12-btn").triggerHandler("click")
                            : this.dY && this.yNext.triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-min0-btn")
                        ? this.dM.find(".AnyTime-min50-btn").triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-sec00-btn")
                        ? this.dM
                            ? this.dM.find(".AnyTime-min9-btn").triggerHandler("click")
                            : this.dH
                            ? this.dH.find(".AnyTime-hr23-btn").triggerHandler("click")
                            : this.dDoM
                            ? this.dDoM.AnyTime_clickCurrent()
                            : this.dMo
                            ? this.dMo.find(".AnyTime-mon12-btn").triggerHandler("click")
                            : this.dY && this.yNext.triggerHandler("click")
                        : this.fBtn.hasClass("AnyTime-sec0-btn")
                        ? this.dS.find(".AnyTime-sec50-btn").triggerHandler("click")
                        : this.fBtn.prev().triggerHandler("click");
                },
                keyDateChange: function (a) {
                    this.fBtn.hasClass("AnyTime-dom-btn") && (this.set(a), this.upd(null), this.setFocus(this.dDoM.find(".AnyTime-cur-btn")));
                },
                makeCloak: function () {
                    this.cloak
                        ? this.cloak.show()
                        : ((this.cloak = a('<div class="AnyTime-cloak"></div>')),
                          this.div.append(this.cloak),
                          this.cloak.click(function (a) {
                              g.oDiv && g.oDiv.is(":visible") ? g.dismissODiv(a) : g.dismissYDiv(a);
                          }));
                },
                makeDate: function (a) {
                    if (("number" == typeof a ? (a = new Date(a)) : "string" == typeof a && (a = this.conv.parse(a)), "getTime" in a)) return a;
                    throw new Exception("cannot make a Date from " + a);
                },
                newHour: function (b) {
                    var c,
                        d,
                        e = a(b.target);
                    if (!e.hasClass("AnyTime-out-btn")) {
                        if (this.twelveHr) {
                            var f = e.text();
                            (d = f.indexOf("a")), 0 > d ? ((d = Number(f.substr(0, f.indexOf("p")))), (c = 12 == d ? 12 : d + 12)) : ((d = Number(f.substr(0, d))), (c = 12 == d ? 0 : d));
                        } else c = Number(e.text());
                        (d = new Date(this.time.getTime())), d.setHours(c), this.set(d), this.upd(e);
                    }
                },
                newOffset: function (a) {
                    a.target == this.oSel[0] ? this.askOffset(a) : this.upd(this.oCur);
                },
                newOPos: function (b) {
                    var c = a(b.target);
                    (this.offMin = c[0].AnyTime_offMin), (this.offSI = c[0].AnyTime_offSI);
                    var d = new Date(this.time.getTime());
                    this.set(d), this.updODiv(c);
                },
                newYear: function (b) {
                    var c = a(b.target);
                    if (!c.hasClass("AnyTime-out-btn")) {
                        var d = c.text();
                        if ("<" == d || "&lt;" == d) this.askYear(b);
                        else if (">" == d || "&gt;" == d) this.askYear(b);
                        else {
                            var e = new Date(this.time.getTime());
                            e.setFullYear(Number(d)), this.set(e), this.upd(this.yCur);
                        }
                    }
                },
                newYPos: function (b) {
                    var c = a(b.target);
                    if (!c.hasClass("AnyTime-out-btn")) {
                        var d = 1,
                            e = this.time.getFullYear();
                        0 > e && ((d = -1), (e = 0 - e)),
                            (e = AnyTime.pad(e, 4)),
                            (e = c.hasClass("AnyTime-mil-btn")
                                ? c.html() + e.substring(1, 4)
                                : c.hasClass("AnyTime-cent-btn")
                                ? e.substring(0, 1) + c.html() + e.substring(2, 4)
                                : c.hasClass("AnyTime-dec-btn")
                                ? e.substring(0, 2) + c.html() + e.substring(3, 4)
                                : e.substring(0, 3) + c.html()),
                            "0000" == e && (e = 1);
                        var f = new Date(this.time.getTime());
                        f.setFullYear(d * e), this.set(f), this.updYDiv(c);
                    }
                },
                onReady: function () {
                    (this.lostFocus = !0), this.pop ? this.div.parent() != document.body && this.div.after(this.input) : this.upd(null);
                },
                pos: function () {
                    if (this.pop) {
                        var b = this.inp.offset(),
                            c = a(document.body).outerWidth(!0),
                            d = this.div.outerWidth(!0),
                            e = b.left;
                        e + d > c - 20 && (e = c - (d + 20));
                        var f = this.inp.outerHeight(!0);
                        0 > f && (f = b.top + this.inp.outerHeight(!0)), this.div.css({ top: "38px", left: "0px" });
                    }
                    var g = this.div.offset();
                    if (this.oDiv && this.oDiv.is(":visible")) {
                        var h = this.oLab.offset();
                        "absolute" == this.div.css("position") && ((h.top -= g.top), (h.left = h.left - g.left), (g = { top: 0, left: 0 }));
                        var i = this.oDiv.outerWidth(!0),
                            j = this.div.outerWidth(!0);
                        h.left + i > g.left + j && ((h.left = g.left + j - i), h.left < 2 && (h.left = 2));
                        var k = this.oDiv.outerHeight(!0),
                            l = this.div.outerHeight(!0);
                        (h.top += this.oLab.outerHeight(!0)), h.top + k > g.top + l && (h.top = h.top - k), h.top < g.top && (h.top = g.top), this.oDiv.css({ top: h.top + "px", left: h.left + "px" });
                    } else if (this.yDiv && this.yDiv.is(":visible")) {
                        var m = this.yLab.offset();
                        "absolute" == this.div.css("position") && ((m.top -= g.top), (m.left = m.left - g.left), (g = { top: 0, left: 0 })),
                            (m.left += (this.yLab.outerWidth(!0) - this.yDiv.outerWidth(!0)) / 2),
                            this.yDiv.css({ top: m.top + "px", left: m.left + "px" });
                    }
                    this.cloak && this.cloak.css({ top: g.top + "px", left: g.left + "px", height: String(this.div.outerHeight(!0) - 2) + "px", width: String(this.div.outerWidth(!0) - 2) + "px" });
                },
                set: function (a) {
                    var b = a.getTime();
                    this.time = this.earliest && b < this.earliest.getTime() ? new Date(this.earliest.getTime()) : this.latest && b > this.latest.getTime() ? new Date(this.latest.getTime()) : a;
                },
                setCurrent: function (a) {
                    this.set(this.makeDate(a)), this.upd(null);
                },
                setEarliest: function (a) {
                    (this.earliest = this.makeDate(a)), this.set(this.time), this.upd(null);
                },
                setLatest: function (a) {
                    (this.latest = this.makeDate(a)), this.set(this.time), this.upd(null);
                },
                showPkr: function (a) {
                    try {
                        (this.time = this.conv.parse(this.inp.val())), (this.offMin = this.conv.getUtcParseOffsetCaptured()), (this.offSI = this.conv.getUtcParseOffsetSubIndex());
                    } catch (b) {
                        this.time = new Date();
                    }
                    this.set(this.time), this.upd(null), (fBtn = null);
                    var c = ".AnyTime-cur-btn:first";
                    this.dDoM
                        ? (fBtn = this.dDoM.find(c))
                        : this.yCur
                        ? (fBtn = this.yCur)
                        : this.dMo
                        ? (fBtn = this.dMo.find(c))
                        : this.dH
                        ? (fBtn = this.dH.find(c))
                        : this.dM
                        ? (fBtn = this.dM.find(c))
                        : this.dS && (fBtn = this.dS.find(c)),
                        this.setFocus(fBtn),
                        this.pos(a);
                },
                upd: function (b) {
                    var c = new Date(this.time.getTime());
                    c.setMonth(0, 1), c.setHours(0, 0, 0, 0);
                    var d = new Date(this.time.getTime());
                    d.setMonth(11, 31), d.setHours(23, 59, 59, 999);
                    var e = this.earliest && this.earliest.getTime(),
                        f = this.latest && this.latest.getTime(),
                        h = this.time.getFullYear();
                    this.earliest && this.yPast && (d.setFullYear(h - 2), d.getTime() < this.earliestTime ? this.yPast.addClass("AnyTime-out-btn ui-state-disabled") : this.yPast.removeClass("AnyTime-out-btn ui-state-disabled")),
                        this.yPrior &&
                            (this.yPrior.text(AnyTime.pad(1 == h ? -1 : h - 1, 4)),
                            this.earliest && (d.setFullYear(h - 1), d.getTime() < this.earliestTime ? this.yPrior.addClass("AnyTime-out-btn ui-state-disabled") : this.yPrior.removeClass("AnyTime-out-btn ui-state-disabled"))),
                        this.yCur && this.yCur.text(AnyTime.pad(h, 4)),
                        this.yNext &&
                            (this.yNext.text(AnyTime.pad(-1 == h ? 1 : h + 1, 4)),
                            this.latest && (c.setFullYear(h + 1), c.getTime() > this.latestTime ? this.yNext.addClass("AnyTime-out-btn ui-state-disabled") : this.yNext.removeClass("AnyTime-out-btn ui-state-disabled"))),
                        this.latest && this.yAhead && (c.setFullYear(h + 2), c.getTime() > this.latestTime ? this.yAhead.addClass("AnyTime-out-btn ui-state-disabled") : this.yAhead.removeClass("AnyTime-out-btn ui-state-disabled")),
                        c.setFullYear(this.time.getFullYear()),
                        d.setFullYear(this.time.getFullYear());
                    var i = 0;
                    (h = this.time.getMonth()),
                        a("#" + this.id + " .AnyTime-mon-btn").each(function () {
                            c.setMonth(i), d.setDate(1), d.setMonth(i + 1), d.setDate(0), a(this).AnyTime_current(i == h, (!g.earliest || d.getTime() >= e) && (!g.latest || c.getTime() <= f)), i++;
                        }),
                        c.setFullYear(this.time.getFullYear()),
                        d.setFullYear(this.time.getFullYear()),
                        c.setMonth(this.time.getMonth()),
                        d.setMonth(this.time.getMonth(), 1),
                        (h = this.time.getDate());
                    var j = this.time.getMonth(),
                        k = -1,
                        l = c.getDay();
                    this.fDOW > l && (l += 7);
                    var m = 0,
                        n = 0;
                    a("#" + this.id + " .AnyTime-wk").each(function () {
                        (n = g.fDOW),
                            a(this)
                                .children()
                                .each(function () {
                                    if (n - g.fDOW < 7) {
                                        var b = a(this);
                                        (0 == m && l > n) || c.getMonth() != j
                                            ? (b.html("&#160;"),
                                              b.removeClass("AnyTime-dom-btn-filled AnyTime-cur-btn ui-state-default ui-state-active"),
                                              b.addClass("AnyTime-dom-btn-empty"),
                                              m
                                                  ? (1 == c.getDate() && 0 != n ? b.addClass("AnyTime-dom-btn-empty-after-filled") : b.removeClass("AnyTime-dom-btn-empty-after-filled"),
                                                    c.getDate() <= 7 ? b.addClass("AnyTime-dom-btn-empty-below-filled") : b.removeClass("AnyTime-dom-btn-empty-below-filled"),
                                                    c.setDate(c.getDate() + 1),
                                                    d.setDate(d.getDate() + 1))
                                                  : (b.addClass("AnyTime-dom-btn-empty-above-filled"), n == l - 1 ? b.addClass("AnyTime-dom-btn-empty-before-filled") : b.removeClass("AnyTime-dom-btn-empty-before-filled")),
                                              b.addClass("ui-state-default ui-state-disabled"))
                                            : ((i = c.getDate()) == k && c.setDate(++i),
                                              (k = i),
                                              b.text(i),
                                              b.removeClass(
                                                  "AnyTime-dom-btn-empty AnyTime-dom-btn-empty-above-filled AnyTime-dom-btn-empty-before-filled AnyTime-dom-btn-empty-after-filled AnyTime-dom-btn-empty-below-filled ui-state-default ui-state-disabled"
                                              ),
                                              b.addClass("AnyTime-dom-btn-filled ui-state-default"),
                                              b.AnyTime_current(i == h, (!g.earliest || d.getTime() >= e) && (!g.latest || c.getTime() <= f)),
                                              c.setDate(i + 1),
                                              d.setDate(i + 1));
                                    }
                                    n++;
                                }),
                            m++;
                    }),
                        c.setFullYear(this.time.getFullYear()),
                        d.setFullYear(this.time.getFullYear()),
                        c.setMonth(this.time.getMonth(), this.time.getDate()),
                        d.setMonth(this.time.getMonth(), this.time.getDate());
                    var o = !this.twelveHr,
                        p = this.time.getHours();
                    a("#" + this.id + " .AnyTime-hr-btn").each(function () {
                        var b,
                            h = this.innerHTML;
                        o ? (b = Number(h)) : ((b = Number(h.substring(0, h.length - 2))), "a" == h.charAt(h.length - 2) ? 12 == b && (b = 0) : 12 > b && (b += 12)),
                            c.setHours(b),
                            d.setHours(b),
                            a(this).AnyTime_current(p == b, (!g.earliest || d.getTime() >= e) && (!g.latest || c.getTime() <= f)),
                            23 > b && c.setHours(c.getHours() + 1);
                    }),
                        c.setHours(this.time.getHours()),
                        d.setHours(this.time.getHours(), 9);
                    var q = this.time.getMinutes(),
                        r = String(Math.floor(q / 10)),
                        s = String(q % 10);
                    if (
                        (a("#" + this.id + " .AnyTime-min-ten-btn:not(.AnyTime-min-ten-btn-empty)").each(function () {
                            a(this).AnyTime_current(this.innerHTML == r, (!g.earliest || d.getTime() >= e) && (!g.latest || c.getTime() <= f)), c.getMinutes() < 50 && (c.setMinutes(c.getMinutes() + 10), d.setMinutes(d.getMinutes() + 10));
                        }),
                        c.setMinutes(10 * Math.floor(this.time.getMinutes() / 10)),
                        d.setMinutes(10 * Math.floor(this.time.getMinutes() / 10)),
                        a("#" + this.id + " .AnyTime-min-one-btn:not(.AnyTime-min-one-btn-empty)").each(function () {
                            a(this).AnyTime_current(this.innerHTML == s, (!g.earliest || d.getTime() >= e) && (!g.latest || c.getTime() <= f)), c.setMinutes(c.getMinutes() + 1), d.setMinutes(d.getMinutes() + 1);
                        }),
                        c.setMinutes(this.time.getMinutes()),
                        d.setMinutes(this.time.getMinutes(), 9),
                        (q = this.time.getSeconds()),
                        (r = String(Math.floor(q / 10))),
                        (s = String(q % 10)),
                        a("#" + this.id + " .AnyTime-sec-ten-btn:not(.AnyTime-sec-ten-btn-empty)").each(function () {
                            a(this).AnyTime_current(this.innerHTML == r, (!g.earliest || d.getTime() >= e) && (!g.latest || c.getTime() <= f)), c.getSeconds() < 50 && (c.setSeconds(c.getSeconds() + 10), d.setSeconds(d.getSeconds() + 10));
                        }),
                        c.setSeconds(10 * Math.floor(this.time.getSeconds() / 10)),
                        d.setSeconds(10 * Math.floor(this.time.getSeconds() / 10)),
                        a("#" + this.id + " .AnyTime-sec-one-btn:not(.AnyTime-sec-one-btn-empty)").each(function () {
                            a(this).AnyTime_current(this.innerHTML == s, (!g.earliest || d.getTime() >= e) && (!g.latest || c.getTime() <= f)), c.setSeconds(c.getSeconds() + 1), d.setSeconds(d.getSeconds() + 1);
                        }),
                        this.oConv)
                    ) {
                        this.oConv.setUtcFormatOffsetAlleged(this.offMin), this.oConv.setUtcFormatOffsetSubIndex(this.offSI);
                        var t = this.oConv.format(this.time);
                        this.oCur.html(t);
                    }
                    if ((b && this.setFocus(b), this.conv.setUtcFormatOffsetAlleged(this.offMin), this.conv.setUtcFormatOffsetSubIndex(this.offSI), this.updVal(this.conv.format(this.time)), this.div.show(), this.dO)) {
                        this.oCur.css("width", "0");
                        var u = this.dT.width() - this.oMinW;
                        40 > u && (u = 40), this.oCur.css("width", String(u) + "px");
                    }
                    this.pop || this.ajax();
                },
                updODiv: function (b) {
                    var c = !1,
                        d = null;
                    this.oDiv.find(".AnyTime-off-off-btn").each(function () {
                        this.AnyTime_offMin == g.offMin ? (this.AnyTime_offSI == g.offSI ? a(this).AnyTime_current((c = !0), !0) : (a(this).AnyTime_current(!1, !0), null == d && (d = a(this)))) : a(this).AnyTime_current(!1, !0);
                    }),
                        c || null == d || d.AnyTime_current(!0, !0),
                        this.conv.setUtcFormatOffsetAlleged(this.offMin),
                        this.conv.setUtcFormatOffsetSubIndex(this.offSI),
                        this.updVal(this.conv.format(this.time)),
                        this.upd(b);
                },
                updYDiv: function (b) {
                    var c,
                        d,
                        e = 1,
                        f = this.time.getFullYear();
                    0 > f && ((e = -1), (f = 0 - f)), (f = AnyTime.pad(f, 4));
                    var h = g.earliest && g.earliest.getFullYear(),
                        i = g.latest && g.latest.getFullYear();
                    (c = 0),
                        this.yDiv.find(".AnyTime-mil-btn").each(function () {
                            (d = (!g.earliest || e * (c + (0 > e ? 0 : 999)) >= h) && (!g.latest || i >= e * (c + (e > 0 ? 0 : 999)))), a(this).AnyTime_current(this.innerHTML == f.substring(0, 1), d), (c += 1e3);
                        }),
                        (c = 1e3 * Math.floor(f / 1e3)),
                        this.yDiv.find(".AnyTime-cent-btn").each(function () {
                            (d = (!g.earliest || e * (c + (0 > e ? 0 : 99)) >= h) && (!g.latest || i >= e * (c + (e > 0 ? 0 : 99)))), a(this).AnyTime_current(this.innerHTML == f.substring(1, 2), d), (c += 100);
                        }),
                        (c = 100 * Math.floor(f / 100)),
                        this.yDiv.find(".AnyTime-dec-btn").each(function () {
                            (d = (!g.earliest || e * (c + (0 > e ? 0 : 9)) >= h) && (!g.latest || i >= e * (c + (e > 0 ? 0 : 9)))), a(this).AnyTime_current(this.innerHTML == f.substring(2, 3), d), (c += 10);
                        }),
                        (c = 10 * Math.floor(f / 10)),
                        this.yDiv.find(".AnyTime-yr-btn").each(function () {
                            (d = (!g.earliest || e * c >= h) && (!g.latest || i >= e * c)), a(this).AnyTime_current(this.innerHTML == f.substring(3), d), (c += 1);
                        }),
                        this.yDiv.find(".AnyTime-bce-btn").each(function () {
                            a(this).AnyTime_current(0 > e, !g.earliest || g.earliest.getFullYear() < 0);
                        }),
                        this.yDiv.find(".AnyTime-ce-btn").each(function () {
                            a(this).AnyTime_current(e > 0, !g.latest || g.latest.getFullYear() > 0);
                        }),
                        this.conv.setUtcFormatOffsetAlleged(this.offMin),
                        this.conv.setUtcFormatOffsetSubIndex(this.offSI),
                        this.updVal(this.conv.format(this.time)),
                        this.upd(b);
                },
                updVal: function (a) {
                    this.inp.val() != a && (this.inp.val(a), this.inp.change());
                },
            }),
                d[e].initialize(e);
        }),
        (AnyTime.setCurrent = function (a, b) {
            d[a].setCurrent(b);
        }),
        (AnyTime.setEarliest = function (a, b) {
            d[a].setEarliest(b);
        }),
        (AnyTime.setLatest = function (a, b) {
            d[a].setLatest(b);
        });
})(jQuery);
