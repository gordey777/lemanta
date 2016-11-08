/* ================================================================================
                                                                                  |
    Скрипт: Основные скрипты.                                                     |
    ----------------------------------------------------------------------------  |
                                                                                  |
    Однофайловая сборка из бывших ранее:                                          |
        js/jquery.min.js                                                          |
        js/jquery-ui.min.js                                                       |
        js/autocomplete/autocomplete.min.js                                       |
        js/jcarousel.min.js                                                       |
        js/script.js                                                              |
        js/select/selectbox.min.js                                                |
        js/mousewheel.js                                                          |
        js/jscroll.js                                                             |
        js/popup.js                                                               |
        js/cloud-zoom.js                                                          |
        js/skdslider/skdslider.js                                                 |
                                                                                  |
    ----------------------------------------------------------------------------  |
    Impera CMS - лёгкий и быстрый скрипт сайта с потрясающими возможностями.      |
    Мы создаём мощные решения с минимальным кодом и высокой скоростью загрузки.   |
                                                                                  |
================================================================================ */

/* ============================================================================
|                                                                             |
|  jquery.min.js                                                              |
|                                                                             |
============================================================================ */

/*! jQuery v1.7.1 jquery.com | jquery.org/license */

(function(a, b) {
  function cy(a) {
    return f.isWindow(a) ? a : a.nodeType === 9 ? a.defaultView || a.parentWindow : !1
  }

  function cv(a) {
    if (!ck[a]) {
      var b = c.body,
        d = f("<" + a + ">").appendTo(b),
        e = d.css("display");
      d.remove();
      if (e === "none" || e === "") {
        cl || (cl = c.createElement("iframe"), cl.frameBorder = cl.width = cl.height = 0), b.appendChild(cl);
        if (!cm || !cl.createElement) cm = (cl.contentWindow || cl.contentDocument).document, cm.write((c.compatMode === "CSS1Compat" ? "<!doctype html>" : "") + "<html><body>"), cm.close();
        d = cm.createElement(a), cm.body.appendChild(d), e = f.css(d, "display"), b.removeChild(cl)
      }
      ck[a] = e
    }
    return ck[a]
  }

  function cu(a, b) {
    var c = {};
    f.each(cq.concat.apply([], cq.slice(0, b)), function() {
      c[this] = a
    });
    return c
  }

  function ct() {
    cr = b
  }

  function cs() {
    setTimeout(ct, 0);
    return cr = f.now()
  }

  function cj() {
    try {
      return new a.ActiveXObject("Microsoft.XMLHTTP")
    } catch (b) {}
  }

  function ci() {
    try {
      return new a.XMLHttpRequest
    } catch (b) {}
  }

  function cc(a, c) {
    a.dataFilter && (c = a.dataFilter(c, a.dataType));
    var d = a.dataTypes,
      e = {},
      g, h, i = d.length,
      j, k = d[0],
      l, m, n, o, p;
    for (g = 1; g < i; g++) {
      if (g === 1)
        for (h in a.converters) typeof h == "string" && (e[h.toLowerCase()] = a.converters[h]);
      l = k, k = d[g];
      if (k === "*") k = l;
      else if (l !== "*" && l !== k) {
        m = l + " " + k, n = e[m] || e["* " + k];
        if (!n) {
          p = b;
          for (o in e) {
            j = o.split(" ");
            if (j[0] === l || j[0] === "*") {
              p = e[j[1] + " " + k];
              if (p) {
                o = e[o], o === !0 ? n = p : p === !0 && (n = o);
                break
              }
            }
          }
        }!n && !p && f.error("No conversion from " + m.replace(" ", " to ")), n !== !0 && (c = n ? n(c) : p(o(c)))
      }
    }
    return c
  }

  function cb(a, c, d) {
    var e = a.contents,
      f = a.dataTypes,
      g = a.responseFields,
      h, i, j, k;
    for (i in g) i in d && (c[g[i]] = d[i]);
    while (f[0] === "*") f.shift(), h === b && (h = a.mimeType || c.getResponseHeader("content-type"));
    if (h)
      for (i in e)
        if (e[i] && e[i].test(h)) {
          f.unshift(i);
          break
        }
    if (f[0] in d) j = f[0];
    else {
      for (i in d) {
        if (!f[0] || a.converters[i + " " + f[0]]) {
          j = i;
          break
        }
        k || (k = i)
      }
      j = j || k
    }
    if (j) {
      j !== f[0] && f.unshift(j);
      return d[j]
    }
  }

  function ca(a, b, c, d) {
    if (f.isArray(b)) f.each(b, function(b, e) {
      c || bE.test(a) ? d(a, e) : ca(a + "[" + (typeof e == "object" || f.isArray(e) ? b : "") + "]", e, c, d)
    });
    else if (!c && b != null && typeof b == "object")
      for (var e in b) ca(a + "[" + e + "]", b[e], c, d);
    else d(a, b)
  }

  function b_(a, c) {
    var d, e, g = f.ajaxSettings.flatOptions || {};
    for (d in c) c[d] !== b && ((g[d] ? a : e || (e = {}))[d] = c[d]);
    e && f.extend(!0, a, e)
  }

  function b$(a, c, d, e, f, g) {
    f = f || c.dataTypes[0], g = g || {}, g[f] = !0;
    var h = a[f],
      i = 0,
      j = h ? h.length : 0,
      k = a === bT,
      l;
    for (; i < j && (k || !l); i++) l = h[i](c, d, e), typeof l == "string" && (!k || g[l] ? l = b : (c.dataTypes.unshift(l), l = b$(a, c, d, e, l, g)));
    (k || !l) && !g["*"] && (l = b$(a, c, d, e, "*", g));
    return l
  }

  function bZ(a) {
    return function(b, c) {
      typeof b != "string" && (c = b, b = "*");
      if (f.isFunction(c)) {
        var d = b.toLowerCase().split(bP),
          e = 0,
          g = d.length,
          h, i, j;
        for (; e < g; e++) h = d[e], j = /^\+/.test(h), j && (h = h.substr(1) || "*"), i = a[h] = a[h] || [], i[j ? "unshift" : "push"](c)
      }
    }
  }

  function bC(a, b, c) {
    var d = b === "width" ? a.offsetWidth : a.offsetHeight,
      e = b === "width" ? bx : by,
      g = 0,
      h = e.length;
    if (d > 0) {
      if (c !== "border")
        for (; g < h; g++) c || (d -= parseFloat(f.css(a, "padding" + e[g])) || 0), c === "margin" ? d += parseFloat(f.css(a, c + e[g])) || 0 : d -= parseFloat(f.css(a, "border" + e[g] + "Width")) || 0;
      return d + "px"
    }
    d = bz(a, b, b);
    if (d < 0 || d == null) d = a.style[b] || 0;
    d = parseFloat(d) || 0;
    if (c)
      for (; g < h; g++) d += parseFloat(f.css(a, "padding" + e[g])) || 0, c !== "padding" && (d += parseFloat(f.css(a, "border" + e[g] + "Width")) || 0), c === "margin" && (d += parseFloat(f.css(a, c + e[g])) || 0);
    return d + "px"
  }

  function bp(a, b) {
    b.src ? f.ajax({
      url: b.src,
      async: !1,
      dataType: "script"
    }) : f.globalEval((b.text || b.textContent || b.innerHTML || "").replace(bf, "/*$0*/")), b.parentNode && b.parentNode.removeChild(b)
  }

  function bo(a) {
    var b = c.createElement("div");
    bh.appendChild(b), b.innerHTML = a.outerHTML;
    return b.firstChild
  }

  function bn(a) {
    var b = (a.nodeName || "").toLowerCase();
    b === "input" ? bm(a) : b !== "script" && typeof a.getElementsByTagName != "undefined" && f.grep(a.getElementsByTagName("input"), bm)
  }

  function bm(a) {
    if (a.type === "checkbox" || a.type === "radio") a.defaultChecked = a.checked
  }

  function bl(a) {
    return typeof a.getElementsByTagName != "undefined" ? a.getElementsByTagName("*") : typeof a.querySelectorAll != "undefined" ? a.querySelectorAll("*") : []
  }

  function bk(a, b) {
    var c;
    if (b.nodeType === 1) {
      b.clearAttributes && b.clearAttributes(), b.mergeAttributes && b.mergeAttributes(a), c = b.nodeName.toLowerCase();
      if (c === "object") b.outerHTML = a.outerHTML;
      else if (c !== "input" || a.type !== "checkbox" && a.type !== "radio") {
        if (c === "option") b.selected = a.defaultSelected;
        else if (c === "input" || c === "textarea") b.defaultValue = a.defaultValue
      } else a.checked && (b.defaultChecked = b.checked = a.checked), b.value !== a.value && (b.value = a.value);
      b.removeAttribute(f.expando)
    }
  }

  function bj(a, b) {
    if (b.nodeType === 1 && !!f.hasData(a)) {
      var c, d, e, g = f._data(a),
        h = f._data(b, g),
        i = g.events;
      if (i) {
        delete h.handle, h.events = {};
        for (c in i)
          for (d = 0, e = i[c].length; d < e; d++) f.event.add(b, c + (i[c][d].namespace ? "." : "") + i[c][d].namespace, i[c][d], i[c][d].data)
      }
      h.data && (h.data = f.extend({}, h.data))
    }
  }

  function bi(a, b) {
    return f.nodeName(a, "table") ? a.getElementsByTagName("tbody")[0] || a.appendChild(a.ownerDocument.createElement("tbody")) : a
  }

  function U(a) {
    var b = V.split("|"),
      c = a.createDocumentFragment();
    if (c.createElement)
      while (b.length) c.createElement(b.pop());
    return c
  }

  function T(a, b, c) {
    b = b || 0;
    if (f.isFunction(b)) return f.grep(a, function(a, d) {
      var e = !!b.call(a, d, a);
      return e === c
    });
    if (b.nodeType) return f.grep(a, function(a, d) {
      return a === b === c
    });
    if (typeof b == "string") {
      var d = f.grep(a, function(a) {
        return a.nodeType === 1
      });
      if (O.test(b)) return f.filter(b, d, !c);
      b = f.filter(b, d)
    }
    return f.grep(a, function(a, d) {
      return f.inArray(a, b) >= 0 === c
    })
  }

  function S(a) {
    return !a || !a.parentNode || a.parentNode.nodeType === 11
  }

  function K() {
    return !0
  }

  function J() {
    return !1
  }

  function n(a, b, c) {
    var d = b + "defer",
      e = b + "queue",
      g = b + "mark",
      h = f._data(a, d);
    h && (c === "queue" || !f._data(a, e)) && (c === "mark" || !f._data(a, g)) && setTimeout(function() {
      !f._data(a, e) && !f._data(a, g) && (f.removeData(a, d, !0), h.fire())
    }, 0)
  }

  function m(a) {
    for (var b in a) {
      if (b === "data" && f.isEmptyObject(a[b])) continue;
      if (b !== "toJSON") return !1
    }
    return !0
  }

  function l(a, c, d) {
    if (d === b && a.nodeType === 1) {
      var e = "data-" + c.replace(k, "-$1").toLowerCase();
      d = a.getAttribute(e);
      if (typeof d == "string") {
        try {
          d = d === "true" ? !0 : d === "false" ? !1 : d === "null" ? null : f.isNumeric(d) ? parseFloat(d) : j.test(d) ? f.parseJSON(d) : d
        } catch (g) {}
        f.data(a, c, d)
      } else d = b
    }
    return d
  }

  function h(a) {
    var b = g[a] = {},
      c, d;
    a = a.split(/\s+/);
    for (c = 0, d = a.length; c < d; c++) b[a[c]] = !0;
    return b
  }
  var c = a.document,
    d = a.navigator,
    e = a.location,
    f = function() {
      function J() {
        if (!e.isReady) {
          try {
            c.documentElement.doScroll("left")
          } catch (a) {
            setTimeout(J, 1);
            return
          }
          e.ready()
        }
      }
      var e = function(a, b) {
          return new e.fn.init(a, b, h)
        },
        f = a.jQuery,
        g = a.$,
        h, i = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,
        j = /\S/,
        k = /^\s+/,
        l = /\s+$/,
        m = /^<(\w+)\s*\/?>(?:<\/\1>)?$/,
        n = /^[\],:{}\s]*$/,
        o = /\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,
        p = /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
        q = /(?:^|:|,)(?:\s*\[)+/g,
        r = /(webkit)[ \/]([\w.]+)/,
        s = /(opera)(?:.*version)?[ \/]([\w.]+)/,
        t = /(msie) ([\w.]+)/,
        u = /(mozilla)(?:.*? rv:([\w.]+))?/,
        v = /-([a-z]|[0-9])/ig,
        w = /^-ms-/,
        x = function(a, b) {
          return (b + "").toUpperCase()
        },
        y = d.userAgent,
        z, A, B, C = Object.prototype.toString,
        D = Object.prototype.hasOwnProperty,
        E = Array.prototype.push,
        F = Array.prototype.slice,
        G = String.prototype.trim,
        H = Array.prototype.indexOf,
        I = {};
      e.fn = e.prototype = {
        constructor: e,
        init: function(a, d, f) {
          var g, h, j, k;
          if (!a) return this;
          if (a.nodeType) {
            this.context = this[0] = a, this.length = 1;
            return this
          }
          if (a === "body" && !d && c.body) {
            this.context = c, this[0] = c.body, this.selector = a, this.length = 1;
            return this
          }
          if (typeof a == "string") {
            a.charAt(0) !== "<" || a.charAt(a.length - 1) !== ">" || a.length < 3 ? g = i.exec(a) : g = [null, a, null];
            if (g && (g[1] || !d)) {
              if (g[1]) {
                d = d instanceof e ? d[0] : d, k = d ? d.ownerDocument || d : c, j = m.exec(a), j ? e.isPlainObject(d) ? (a = [c.createElement(j[1])], e.fn.attr.call(a, d, !0)) : a = [k.createElement(j[1])] : (j = e.buildFragment([g[1]], [k]), a = (j.cacheable ? e.clone(j.fragment) : j.fragment).childNodes);
                return e.merge(this, a)
              }
              h = c.getElementById(g[2]);
              if (h && h.parentNode) {
                if (h.id !== g[2]) return f.find(a);
                this.length = 1, this[0] = h
              }
              this.context = c, this.selector = a;
              return this
            }
            return !d || d.jquery ? (d || f).find(a) : this.constructor(d).find(a)
          }
          if (e.isFunction(a)) return f.ready(a);
          a.selector !== b && (this.selector = a.selector, this.context = a.context);
          return e.makeArray(a, this)
        },
        selector: "",
        jquery: "1.7.1",
        length: 0,
        size: function() {
          return this.length
        },
        toArray: function() {
          return F.call(this, 0)
        },
        get: function(a) {
          return a == null ? this.toArray() : a < 0 ? this[this.length + a] : this[a]
        },
        pushStack: function(a, b, c) {
          var d = this.constructor();
          e.isArray(a) ? E.apply(d, a) : e.merge(d, a), d.prevObject = this, d.context = this.context, b === "find" ? d.selector = this.selector + (this.selector ? " " : "") + c : b && (d.selector = this.selector + "." + b + "(" + c + ")");
          return d
        },
        each: function(a, b) {
          return e.each(this, a, b)
        },
        ready: function(a) {
          e.bindReady(), A.add(a);
          return this
        },
        eq: function(a) {
          a = +a;
          return a === -1 ? this.slice(a) : this.slice(a, a + 1)
        },
        first: function() {
          return this.eq(0)
        },
        last: function() {
          return this.eq(-1)
        },
        slice: function() {
          return this.pushStack(F.apply(this, arguments), "slice", F.call(arguments).join(","))
        },
        map: function(a) {
          return this.pushStack(e.map(this, function(b, c) {
            return a.call(b, c, b)
          }))
        },
        end: function() {
          return this.prevObject || this.constructor(null)
        },
        push: E,
        sort: [].sort,
        splice: [].splice
      }, e.fn.init.prototype = e.fn, e.extend = e.fn.extend = function() {
        var a, c, d, f, g, h, i = arguments[0] || {},
          j = 1,
          k = arguments.length,
          l = !1;
        typeof i == "boolean" && (l = i, i = arguments[1] || {}, j = 2), typeof i != "object" && !e.isFunction(i) && (i = {}), k === j && (i = this, --j);
        for (; j < k; j++)
          if ((a = arguments[j]) != null)
            for (c in a) {
              d = i[c], f = a[c];
              if (i === f) continue;
              l && f && (e.isPlainObject(f) || (g = e.isArray(f))) ? (g ? (g = !1, h = d && e.isArray(d) ? d : []) : h = d && e.isPlainObject(d) ? d : {}, i[c] = e.extend(l, h, f)) : f !== b && (i[c] = f)
            }
          return i
      }, e.extend({
        noConflict: function(b) {
          a.$ === e && (a.$ = g), b && a.jQuery === e && (a.jQuery = f);
          return e
        },
        isReady: !1,
        readyWait: 1,
        holdReady: function(a) {
          a ? e.readyWait++ : e.ready(!0)
        },
        ready: function(a) {
          if (a === !0 && !--e.readyWait || a !== !0 && !e.isReady) {
            if (!c.body) return setTimeout(e.ready, 1);
            e.isReady = !0;
            if (a !== !0 && --e.readyWait > 0) return;
            A.fireWith(c, [e]), e.fn.trigger && e(c).trigger("ready").off("ready")
          }
        },
        bindReady: function() {
          if (!A) {
            A = e.Callbacks("once memory");
            if (c.readyState === "complete") return setTimeout(e.ready, 1);
            if (c.addEventListener) c.addEventListener("DOMContentLoaded", B, !1), a.addEventListener("load", e.ready, !1);
            else if (c.attachEvent) {
              c.attachEvent("onreadystatechange", B), a.attachEvent("onload", e.ready);
              var b = !1;
              try {
                b = a.frameElement == null
              } catch (d) {}
              c.documentElement.doScroll && b && J()
            }
          }
        },
        isFunction: function(a) {
          return e.type(a) === "function"
        },
        isArray: Array.isArray || function(a) {
          return e.type(a) === "array"
        },
        isWindow: function(a) {
          return a && typeof a == "object" && "setInterval" in a
        },
        isNumeric: function(a) {
          return !isNaN(parseFloat(a)) && isFinite(a)
        },
        type: function(a) {
          return a == null ? String(a) : I[C.call(a)] || "object"
        },
        isPlainObject: function(a) {
          if (!a || e.type(a) !== "object" || a.nodeType || e.isWindow(a)) return !1;
          try {
            if (a.constructor && !D.call(a, "constructor") && !D.call(a.constructor.prototype, "isPrototypeOf")) return !1
          } catch (c) {
            return !1
          }
          var d;
          for (d in a);
          return d === b || D.call(a, d)
        },
        isEmptyObject: function(a) {
          for (var b in a) return !1;
          return !0
        },
        error: function(a) {
          throw new Error(a)
        },
        parseJSON: function(b) {
          if (typeof b != "string" || !b) return null;
          b = e.trim(b);
          if (a.JSON && a.JSON.parse) return a.JSON.parse(b);
          if (n.test(b.replace(o, "@").replace(p, "]").replace(q, ""))) return (new Function("return " + b))();
          e.error("Invalid JSON: " + b)
        },
        parseXML: function(c) {
          var d, f;
          try {
            a.DOMParser ? (f = new DOMParser, d = f.parseFromString(c, "text/xml")) : (d = new ActiveXObject("Microsoft.XMLDOM"), d.async = "false", d.loadXML(c))
          } catch (g) {
            d = b
          }(!d || !d.documentElement || d.getElementsByTagName("parsererror").length) && e.error("Invalid XML: " + c);
          return d
        },
        noop: function() {},
        globalEval: function(b) {
          b && j.test(b) && (a.execScript || function(b) {
            a.eval.call(a, b)
          })(b)
        },
        camelCase: function(a) {
          return a.replace(w, "ms-").replace(v, x)
        },
        nodeName: function(a, b) {
          return a.nodeName && a.nodeName.toUpperCase() === b.toUpperCase()
        },
        each: function(a, c, d) {
          var f, g = 0,
            h = a.length,
            i = h === b || e.isFunction(a);
          if (d) {
            if (i) {
              for (f in a)
                if (c.apply(a[f], d) === !1) break
            } else
              for (; g < h;)
                if (c.apply(a[g++], d) === !1) break
          } else if (i) {
            for (f in a)
              if (c.call(a[f], f, a[f]) === !1) break
          } else
            for (; g < h;)
              if (c.call(a[g], g, a[g++]) === !1) break; return a
        },
        trim: G ? function(a) {
          return a == null ? "" : G.call(a)
        } : function(a) {
          return a == null ? "" : (a + "").replace(k, "").replace(l, "")
        },
        makeArray: function(a, b) {
          var c = b || [];
          if (a != null) {
            var d = e.type(a);
            a.length == null || d === "string" || d === "function" || d === "regexp" || e.isWindow(a) ? E.call(c, a) : e.merge(c, a)
          }
          return c
        },
        inArray: function(a, b, c) {
          var d;
          if (b) {
            if (H) return H.call(b, a, c);
            d = b.length, c = c ? c < 0 ? Math.max(0, d + c) : c : 0;
            for (; c < d; c++)
              if (c in b && b[c] === a) return c
          }
          return -1
        },
        merge: function(a, c) {
          var d = a.length,
            e = 0;
          if (typeof c.length == "number")
            for (var f = c.length; e < f; e++) a[d++] = c[e];
          else
            while (c[e] !== b) a[d++] = c[e++];
          a.length = d;
          return a
        },
        grep: function(a, b, c) {
          var d = [],
            e;
          c = !!c;
          for (var f = 0, g = a.length; f < g; f++) e = !!b(a[f], f), c !== e && d.push(a[f]);
          return d
        },
        map: function(a, c, d) {
          var f, g, h = [],
            i = 0,
            j = a.length,
            k = a instanceof e || j !== b && typeof j == "number" && (j > 0 && a[0] && a[j - 1] || j === 0 || e.isArray(a));
          if (k)
            for (; i < j; i++) f = c(a[i], i, d), f != null && (h[h.length] = f);
          else
            for (g in a) f = c(a[g], g, d), f != null && (h[h.length] = f);
          return h.concat.apply([], h)
        },
        guid: 1,
        proxy: function(a, c) {
          if (typeof c == "string") {
            var d = a[c];
            c = a, a = d
          }
          if (!e.isFunction(a)) return b;
          var f = F.call(arguments, 2),
            g = function() {
              return a.apply(c, f.concat(F.call(arguments)))
            };
          g.guid = a.guid = a.guid || g.guid || e.guid++;
          return g
        },
        access: function(a, c, d, f, g, h) {
          var i = a.length;
          if (typeof c == "object") {
            for (var j in c) e.access(a, j, c[j], f, g, d);
            return a
          }
          if (d !== b) {
            f = !h && f && e.isFunction(d);
            for (var k = 0; k < i; k++) g(a[k], c, f ? d.call(a[k], k, g(a[k], c)) : d, h);
            return a
          }
          return i ? g(a[0], c) : b
        },
        now: function() {
          return (new Date).getTime()
        },
        uaMatch: function(a) {
          a = a.toLowerCase();
          var b = r.exec(a) || s.exec(a) || t.exec(a) || a.indexOf("compatible") < 0 && u.exec(a) || [];
          return {
            browser: b[1] || "",
            version: b[2] || "0"
          }
        },
        sub: function() {
          function a(b, c) {
            return new a.fn.init(b, c)
          }
          e.extend(!0, a, this), a.superclass = this, a.fn = a.prototype = this(), a.fn.constructor = a, a.sub = this.sub, a.fn.init = function(d, f) {
            f && f instanceof e && !(f instanceof a) && (f = a(f));
            return e.fn.init.call(this, d, f, b)
          }, a.fn.init.prototype = a.fn;
          var b = a(c);
          return a
        },
        browser: {}
      }), e.each("Boolean Number String Function Array Date RegExp Object".split(" "), function(a, b) {
        I["[object " + b + "]"] = b.toLowerCase()
      }), z = e.uaMatch(y), z.browser && (e.browser[z.browser] = !0, e.browser.version = z.version), e.browser.webkit && (e.browser.safari = !0), j.test(" ") && (k = /^[\s\xA0]+/, l = /[\s\xA0]+$/), h = e(c), c.addEventListener ? B = function() {
        c.removeEventListener("DOMContentLoaded", B, !1), e.ready()
      } : c.attachEvent && (B = function() {
        c.readyState === "complete" && (c.detachEvent("onreadystatechange", B), e.ready())
      });
      return e
    }(),
    g = {};
  f.Callbacks = function(a) {
    a = a ? g[a] || h(a) : {};
    var c = [],
      d = [],
      e, i, j, k, l, m = function(b) {
        var d, e, g, h, i;
        for (d = 0, e = b.length; d < e; d++) g = b[d], h = f.type(g), h === "array" ? m(g) : h === "function" && (!a.unique || !o.has(g)) && c.push(g)
      },
      n = function(b, f) {
        f = f || [], e = !a.memory || [b, f], i = !0, l = j || 0, j = 0, k = c.length;
        for (; c && l < k; l++)
          if (c[l].apply(b, f) === !1 && a.stopOnFalse) {
            e = !0;
            break
          }
        i = !1, c && (a.once ? e === !0 ? o.disable() : c = [] : d && d.length && (e = d.shift(), o.fireWith(e[0], e[1])))
      },
      o = {
        add: function() {
          if (c) {
            var a = c.length;
            m(arguments), i ? k = c.length : e && e !== !0 && (j = a, n(e[0], e[1]))
          }
          return this
        },
        remove: function() {
          if (c) {
            var b = arguments,
              d = 0,
              e = b.length;
            for (; d < e; d++)
              for (var f = 0; f < c.length; f++)
                if (b[d] === c[f]) {
                  i && f <= k && (k--, f <= l && l--), c.splice(f--, 1);
                  if (a.unique) break
                }
          }
          return this
        },
        has: function(a) {
          if (c) {
            var b = 0,
              d = c.length;
            for (; b < d; b++)
              if (a === c[b]) return !0
          }
          return !1
        },
        empty: function() {
          c = [];
          return this
        },
        disable: function() {
          c = d = e = b;
          return this
        },
        disabled: function() {
          return !c
        },
        lock: function() {
          d = b, (!e || e === !0) && o.disable();
          return this
        },
        locked: function() {
          return !d
        },
        fireWith: function(b, c) {
          d && (i ? a.once || d.push([b, c]) : (!a.once || !e) && n(b, c));
          return this
        },
        fire: function() {
          o.fireWith(this, arguments);
          return this
        },
        fired: function() {
          return !!e
        }
      };
    return o
  };
  var i = [].slice;
  f.extend({
    Deferred: function(a) {
      var b = f.Callbacks("once memory"),
        c = f.Callbacks("once memory"),
        d = f.Callbacks("memory"),
        e = "pending",
        g = {
          resolve: b,
          reject: c,
          notify: d
        },
        h = {
          done: b.add,
          fail: c.add,
          progress: d.add,
          state: function() {
            return e
          },
          isResolved: b.fired,
          isRejected: c.fired,
          then: function(a, b, c) {
            i.done(a).fail(b).progress(c);
            return this
          },
          always: function() {
            i.done.apply(i, arguments).fail.apply(i, arguments);
            return this
          },
          pipe: function(a, b, c) {
            return f.Deferred(function(d) {
              f.each({
                done: [a, "resolve"],
                fail: [b, "reject"],
                progress: [c, "notify"]
              }, function(a, b) {
                var c = b[0],
                  e = b[1],
                  g;
                f.isFunction(c) ? i[a](function() {
                  g = c.apply(this, arguments), g && f.isFunction(g.promise) ? g.promise().then(d.resolve, d.reject, d.notify) : d[e + "With"](this === i ? d : this, [g])
                }) : i[a](d[e])
              })
            }).promise()
          },
          promise: function(a) {
            if (a == null) a = h;
            else
              for (var b in h) a[b] = h[b];
            return a
          }
        },
        i = h.promise({}),
        j;
      for (j in g) i[j] = g[j].fire, i[j + "With"] = g[j].fireWith;
      i.done(function() {
        e = "resolved"
      }, c.disable, d.lock).fail(function() {
        e = "rejected"
      }, b.disable, d.lock), a && a.call(i, i);
      return i
    },
    when: function(a) {
      function m(a) {
        return function(b) {
          e[a] = arguments.length > 1 ? i.call(arguments, 0) : b, j.notifyWith(k, e)
        }
      }

      function l(a) {
        return function(c) {
          b[a] = arguments.length > 1 ? i.call(arguments, 0) : c, --g || j.resolveWith(j, b)
        }
      }
      var b = i.call(arguments, 0),
        c = 0,
        d = b.length,
        e = Array(d),
        g = d,
        h = d,
        j = d <= 1 && a && f.isFunction(a.promise) ? a : f.Deferred(),
        k = j.promise();
      if (d > 1) {
        for (; c < d; c++) b[c] && b[c].promise && f.isFunction(b[c].promise) ? b[c].promise().then(l(c), j.reject, m(c)) : --g;
        g || j.resolveWith(j, b)
      } else j !== a && j.resolveWith(j, d ? [a] : []);
      return k
    }
  }), f.support = function() {
    var b, d, e, g, h, i, j, k, l, m, n, o, p, q = c.createElement("div"),
      r = c.documentElement;
    q.setAttribute("className", "t"), q.innerHTML = "   <link/><table></table><a href='/a' style='top:1px;float:left;opacity:.55;'>a</a><input type='checkbox'/>", d = q.getElementsByTagName("*"), e = q.getElementsByTagName("a")[0];
    if (!d || !d.length || !e) return {};
    g = c.createElement("select"), h = g.appendChild(c.createElement("option")), i = q.getElementsByTagName("input")[0], b = {
      leadingWhitespace: q.firstChild.nodeType === 3,
      tbody: !q.getElementsByTagName("tbody").length,
      htmlSerialize: !!q.getElementsByTagName("link").length,
      style: /top/.test(e.getAttribute("style")),
      hrefNormalized: e.getAttribute("href") === "/a",
      opacity: /^0.55/.test(e.style.opacity),
      cssFloat: !!e.style.cssFloat,
      checkOn: i.value === "on",
      optSelected: h.selected,
      getSetAttribute: q.className !== "t",
      enctype: !!c.createElement("form").enctype,
      html5Clone: c.createElement("nav").cloneNode(!0).outerHTML !== "<:nav></:nav>",
      submitBubbles: !0,
      changeBubbles: !0,
      focusinBubbles: !1,
      deleteExpando: !0,
      noCloneEvent: !0,
      inlineBlockNeedsLayout: !1,
      shrinkWrapBlocks: !1,
      reliableMarginRight: !0
    }, i.checked = !0, b.noCloneChecked = i.cloneNode(!0).checked, g.disabled = !0, b.optDisabled = !h.disabled;
    try {
      delete q.test
    } catch (s) {
      b.deleteExpando = !1
    }!q.addEventListener && q.attachEvent && q.fireEvent && (q.attachEvent("onclick", function() {
      b.noCloneEvent = !1
    }), q.cloneNode(!0).fireEvent("onclick")), i = c.createElement("input"), i.value = "t", i.setAttribute("type", "radio"), b.radioValue = i.value === "t", i.setAttribute("checked", "checked"), q.appendChild(i), k = c.createDocumentFragment(), k.appendChild(q.lastChild), b.checkClone = k.cloneNode(!0).cloneNode(!0).lastChild.checked, b.appendChecked = i.checked, k.removeChild(i), k.appendChild(q), q.innerHTML = "", a.getComputedStyle && (j = c.createElement("div"), j.style.width = "0", j.style.marginRight = "0", q.style.width = "2px", q.appendChild(j), b.reliableMarginRight = (parseInt((a.getComputedStyle(j, null) || {
      marginRight: 0
    }).marginRight, 10) || 0) === 0);
    if (q.attachEvent)
      for (o in {
          submit: 1,
          change: 1,
          focusin: 1
        }) n = "on" + o, p = n in q, p || (q.setAttribute(n, "return;"), p = typeof q[n] == "function"), b[o + "Bubbles"] = p;
    k.removeChild(q), k = g = h = j = q = i = null, f(function() {
      var a, d, e, g, h, i, j, k, m, n, o, r = c.getElementsByTagName("body")[0];
      !r || (j = 1, k = "position:absolute;top:0;left:0;width:1px;height:1px;margin:0;", m = "visibility:hidden;border:0;", n = "style='" + k + "border:5px solid #000;padding:0;'", o = "<div " + n + "><div></div></div>" + "<table " + n + " cellpadding='0' cellspacing='0'>" + "<tr><td></td></tr></table>", a = c.createElement("div"), a.style.cssText = m + "width:0;height:0;position:static;top:0;margin-top:" + j + "px", r.insertBefore(a, r.firstChild), q = c.createElement("div"), a.appendChild(q), q.innerHTML = "<table><tr><td style='padding:0;border:0;display:none'></td><td>t</td></tr></table>", l = q.getElementsByTagName("td"), p = l[0].offsetHeight === 0, l[0].style.display = "", l[1].style.display = "none", b.reliableHiddenOffsets = p && l[0].offsetHeight === 0, q.innerHTML = "", q.style.width = q.style.paddingLeft = "1px", f.boxModel = b.boxModel = q.offsetWidth === 2, typeof q.style.zoom != "undefined" && (q.style.display = "inline", q.style.zoom = 1, b.inlineBlockNeedsLayout = q.offsetWidth === 2, q.style.display = "", q.innerHTML = "<div style='width:4px;'></div>", b.shrinkWrapBlocks = q.offsetWidth !== 2), q.style.cssText = k + m, q.innerHTML = o, d = q.firstChild, e = d.firstChild, h = d.nextSibling.firstChild.firstChild, i = {
        doesNotAddBorder: e.offsetTop !== 5,
        doesAddBorderForTableAndCells: h.offsetTop === 5
      }, e.style.position = "fixed", e.style.top = "20px", i.fixedPosition = e.offsetTop === 20 || e.offsetTop === 15, e.style.position = e.style.top = "", d.style.overflow = "hidden", d.style.position = "relative", i.subtractsBorderForOverflowNotVisible = e.offsetTop === -5, i.doesNotIncludeMarginInBodyOffset = r.offsetTop !== j, r.removeChild(a), q = a = null, f.extend(b, i))
    });
    return b
  }();
  var j = /^(?:\{.*\}|\[.*\])$/,
    k = /([A-Z])/g;
  f.extend({
    cache: {},
    uuid: 0,
    expando: "jQuery" + (f.fn.jquery + Math.random()).replace(/\D/g, ""),
    noData: {
      embed: !0,
      object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
      applet: !0
    },
    hasData: function(a) {
      a = a.nodeType ? f.cache[a[f.expando]] : a[f.expando];
      return !!a && !m(a)
    },
    data: function(a, c, d, e) {
      if (!!f.acceptData(a)) {
        var g, h, i, j = f.expando,
          k = typeof c == "string",
          l = a.nodeType,
          m = l ? f.cache : a,
          n = l ? a[j] : a[j] && j,
          o = c === "events";
        if ((!n || !m[n] || !o && !e && !m[n].data) && k && d === b) return;
        n || (l ? a[j] = n = ++f.uuid : n = j), m[n] || (m[n] = {}, l || (m[n].toJSON = f.noop));
        if (typeof c == "object" || typeof c == "function") e ? m[n] = f.extend(m[n], c) : m[n].data = f.extend(m[n].data, c);
        g = h = m[n], e || (h.data || (h.data = {}), h = h.data), d !== b && (h[f.camelCase(c)] = d);
        if (o && !h[c]) return g.events;
        k ? (i = h[c], i == null && (i = h[f.camelCase(c)])) : i = h;
        return i
      }
    },
    removeData: function(a, b, c) {
      if (!!f.acceptData(a)) {
        var d, e, g, h = f.expando,
          i = a.nodeType,
          j = i ? f.cache : a,
          k = i ? a[h] : h;
        if (!j[k]) return;
        if (b) {
          d = c ? j[k] : j[k].data;
          if (d) {
            f.isArray(b) || (b in d ? b = [b] : (b = f.camelCase(b), b in d ? b = [b] : b = b.split(" ")));
            for (e = 0, g = b.length; e < g; e++) delete d[b[e]];
            if (!(c ? m : f.isEmptyObject)(d)) return
          }
        }
        if (!c) {
          delete j[k].data;
          if (!m(j[k])) return
        }
        f.support.deleteExpando || !j.setInterval ? delete j[k] : j[k] = null, i && (f.support.deleteExpando ? delete a[h] : a.removeAttribute ? a.removeAttribute(h) : a[h] = null)
      }
    },
    _data: function(a, b, c) {
      return f.data(a, b, c, !0)
    },
    acceptData: function(a) {
      if (a.nodeName) {
        var b = f.noData[a.nodeName.toLowerCase()];
        if (b) return b !== !0 && a.getAttribute("classid") === b
      }
      return !0
    }
  }), f.fn.extend({
    data: function(a, c) {
      var d, e, g, h = null;
      if (typeof a == "undefined") {
        if (this.length) {
          h = f.data(this[0]);
          if (this[0].nodeType === 1 && !f._data(this[0], "parsedAttrs")) {
            e = this[0].attributes;
            for (var i = 0, j = e.length; i < j; i++) g = e[i].name, g.indexOf("data-") === 0 && (g = f.camelCase(g.substring(5)), l(this[0], g, h[g]));
            f._data(this[0], "parsedAttrs", !0)
          }
        }
        return h
      }
      if (typeof a == "object") return this.each(function() {
        f.data(this, a)
      });
      d = a.split("."), d[1] = d[1] ? "." + d[1] : "";
      if (c === b) {
        h = this.triggerHandler("getData" + d[1] + "!", [d[0]]), h === b && this.length && (h = f.data(this[0], a), h = l(this[0], a, h));
        return h === b && d[1] ? this.data(d[0]) : h
      }
      return this.each(function() {
        var b = f(this),
          e = [d[0], c];
        b.triggerHandler("setData" + d[1] + "!", e), f.data(this, a, c), b.triggerHandler("changeData" + d[1] + "!", e)
      })
    },
    removeData: function(a) {
      return this.each(function() {
        f.removeData(this, a)
      })
    }
  }), f.extend({
    _mark: function(a, b) {
      a && (b = (b || "fx") + "mark", f._data(a, b, (f._data(a, b) || 0) + 1))
    },
    _unmark: function(a, b, c) {
      a !== !0 && (c = b, b = a, a = !1);
      if (b) {
        c = c || "fx";
        var d = c + "mark",
          e = a ? 0 : (f._data(b, d) || 1) - 1;
        e ? f._data(b, d, e) : (f.removeData(b, d, !0), n(b, c, "mark"))
      }
    },
    queue: function(a, b, c) {
      var d;
      if (a) {
        b = (b || "fx") + "queue", d = f._data(a, b), c && (!d || f.isArray(c) ? d = f._data(a, b, f.makeArray(c)) : d.push(c));
        return d || []
      }
    },
    dequeue: function(a, b) {
      b = b || "fx";
      var c = f.queue(a, b),
        d = c.shift(),
        e = {};
      d === "inprogress" && (d = c.shift()), d && (b === "fx" && c.unshift("inprogress"), f._data(a, b + ".run", e), d.call(a, function() {
        f.dequeue(a, b)
      }, e)), c.length || (f.removeData(a, b + "queue " + b + ".run", !0), n(a, b, "queue"))
    }
  }), f.fn.extend({
    queue: function(a, c) {
      typeof a != "string" && (c = a, a = "fx");
      if (c === b) return f.queue(this[0], a);
      return this.each(function() {
        var b = f.queue(this, a, c);
        a === "fx" && b[0] !== "inprogress" && f.dequeue(this, a)
      })
    },
    dequeue: function(a) {
      return this.each(function() {
        f.dequeue(this, a)
      })
    },
    delay: function(a, b) {
      a = f.fx ? f.fx.speeds[a] || a : a, b = b || "fx";
      return this.queue(b, function(b, c) {
        var d = setTimeout(b, a);
        c.stop = function() {
          clearTimeout(d)
        }
      })
    },
    clearQueue: function(a) {
      return this.queue(a || "fx", [])
    },
    promise: function(a, c) {
      function m() {
        --h || d.resolveWith(e, [e])
      }
      typeof a != "string" && (c = a, a = b), a = a || "fx";
      var d = f.Deferred(),
        e = this,
        g = e.length,
        h = 1,
        i = a + "defer",
        j = a + "queue",
        k = a + "mark",
        l;
      while (g--)
        if (l = f.data(e[g], i, b, !0) || (f.data(e[g], j, b, !0) || f.data(e[g], k, b, !0)) && f.data(e[g], i, f.Callbacks("once memory"), !0)) h++, l.add(m);
      m();
      return d.promise()
    }
  });
  var o = /[\n\t\r]/g,
    p = /\s+/,
    q = /\r/g,
    r = /^(?:button|input)$/i,
    s = /^(?:button|input|object|select|textarea)$/i,
    t = /^a(?:rea)?$/i,
    u = /^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
    v = f.support.getSetAttribute,
    w, x, y;
  f.fn.extend({
    attr: function(a, b) {
      return f.access(this, a, b, !0, f.attr)
    },
    removeAttr: function(a) {
      return this.each(function() {
        f.removeAttr(this, a)
      })
    },
    prop: function(a, b) {
      return f.access(this, a, b, !0, f.prop)
    },
    removeProp: function(a) {
      a = f.propFix[a] || a;
      return this.each(function() {
        try {
          this[a] = b, delete this[a]
        } catch (c) {}
      })
    },
    addClass: function(a) {
      var b, c, d, e, g, h, i;
      if (f.isFunction(a)) return this.each(function(b) {
        f(this).addClass(a.call(this, b, this.className))
      });
      if (a && typeof a == "string") {
        b = a.split(p);
        for (c = 0, d = this.length; c < d; c++) {
          e = this[c];
          if (e.nodeType === 1)
            if (!e.className && b.length === 1) e.className = a;
            else {
              g = " " + e.className + " ";
              for (h = 0, i = b.length; h < i; h++) ~g.indexOf(" " + b[h] + " ") || (g += b[h] + " ");
              e.className = f.trim(g)
            }
        }
      }
      return this
    },
    removeClass: function(a) {
      var c, d, e, g, h, i, j;
      if (f.isFunction(a)) return this.each(function(b) {
        f(this).removeClass(a.call(this, b, this.className))
      });
      if (a && typeof a == "string" || a === b) {
        c = (a || "").split(p);
        for (d = 0, e = this.length; d < e; d++) {
          g = this[d];
          if (g.nodeType === 1 && g.className)
            if (a) {
              h = (" " + g.className + " ").replace(o, " ");
              for (i = 0, j = c.length; i < j; i++) h = h.replace(" " + c[i] + " ", " ");
              g.className = f.trim(h)
            } else g.className = ""
        }
      }
      return this
    },
    toggleClass: function(a, b) {
      var c = typeof a,
        d = typeof b == "boolean";
      if (f.isFunction(a)) return this.each(function(c) {
        f(this).toggleClass(a.call(this, c, this.className, b), b)
      });
      return this.each(function() {
        if (c === "string") {
          var e, g = 0,
            h = f(this),
            i = b,
            j = a.split(p);
          while (e = j[g++]) i = d ? i : !h.hasClass(e), h[i ? "addClass" : "removeClass"](e)
        } else if (c === "undefined" || c === "boolean") this.className && f._data(this, "__className__", this.className), this.className = this.className || a === !1 ? "" : f._data(this, "__className__") || ""
      })
    },
    hasClass: function(a) {
      var b = " " + a + " ",
        c = 0,
        d = this.length;
      for (; c < d; c++)
        if (this[c].nodeType === 1 && (" " + this[c].className + " ").replace(o, " ").indexOf(b) > -1) return !0;
      return !1
    },
    val: function(a) {
      var c, d, e, g = this[0]; {
        if (!!arguments.length) {
          e = f.isFunction(a);
          return this.each(function(d) {
            var g = f(this),
              h;
            if (this.nodeType === 1) {
              e ? h = a.call(this, d, g.val()) : h = a, h == null ? h = "" : typeof h == "number" ? h += "" : f.isArray(h) && (h = f.map(h, function(a) {
                return a == null ? "" : a + ""
              })), c = f.valHooks[this.nodeName.toLowerCase()] || f.valHooks[this.type];
              if (!c || !("set" in c) || c.set(this, h, "value") === b) this.value = h
            }
          })
        }
        if (g) {
          c = f.valHooks[g.nodeName.toLowerCase()] || f.valHooks[g.type];
          if (c && "get" in c && (d = c.get(g, "value")) !== b) return d;
          d = g.value;
          return typeof d == "string" ? d.replace(q, "") : d == null ? "" : d
        }
      }
    }
  }), f.extend({
    valHooks: {
      option: {
        get: function(a) {
          var b = a.attributes.value;
          return !b || b.specified ? a.value : a.text
        }
      },
      select: {
        get: function(a) {
          var b, c, d, e, g = a.selectedIndex,
            h = [],
            i = a.options,
            j = a.type === "select-one";
          if (g < 0) return null;
          c = j ? g : 0, d = j ? g + 1 : i.length;
          for (; c < d; c++) {
            e = i[c];
            if (e.selected && (f.support.optDisabled ? !e.disabled : e.getAttribute("disabled") === null) && (!e.parentNode.disabled || !f.nodeName(e.parentNode, "optgroup"))) {
              b = f(e).val();
              if (j) return b;
              h.push(b)
            }
          }
          if (j && !h.length && i.length) return f(i[g]).val();
          return h
        },
        set: function(a, b) {
          var c = f.makeArray(b);
          f(a).find("option").each(function() {
            this.selected = f.inArray(f(this).val(), c) >= 0
          }), c.length || (a.selectedIndex = -1);
          return c
        }
      }
    },
    attrFn: {
      val: !0,
      css: !0,
      html: !0,
      text: !0,
      data: !0,
      width: !0,
      height: !0,
      offset: !0
    },
    attr: function(a, c, d, e) {
      var g, h, i, j = a.nodeType;
      if (!!a && j !== 3 && j !== 8 && j !== 2) {
        if (e && c in f.attrFn) return f(a)[c](d);
        if (typeof a.getAttribute == "undefined") return f.prop(a, c, d);
        i = j !== 1 || !f.isXMLDoc(a), i && (c = c.toLowerCase(), h = f.attrHooks[c] || (u.test(c) ? x : w));
        if (d !== b) {
          if (d === null) {
            f.removeAttr(a, c);
            return
          }
          if (h && "set" in h && i && (g = h.set(a, d, c)) !== b) return g;
          a.setAttribute(c, "" + d);
          return d
        }
        if (h && "get" in h && i && (g = h.get(a, c)) !== null) return g;
        g = a.getAttribute(c);
        return g === null ? b : g
      }
    },
    removeAttr: function(a, b) {
      var c, d, e, g, h = 0;
      if (b && a.nodeType === 1) {
        d = b.toLowerCase().split(p), g = d.length;
        for (; h < g; h++) e = d[h], e && (c = f.propFix[e] || e, f.attr(a, e, ""), a.removeAttribute(v ? e : c), u.test(e) && c in a && (a[c] = !1))
      }
    },
    attrHooks: {
      type: {
        set: function(a, b) {
          if (r.test(a.nodeName) && a.parentNode) f.error("type property can't be changed");
          else if (!f.support.radioValue && b === "radio" && f.nodeName(a, "input")) {
            var c = a.value;
            a.setAttribute("type", b), c && (a.value = c);
            return b
          }
        }
      },
      value: {
        get: function(a, b) {
          if (w && f.nodeName(a, "button")) return w.get(a, b);
          return b in a ? a.value : null
        },
        set: function(a, b, c) {
          if (w && f.nodeName(a, "button")) return w.set(a, b, c);
          a.value = b
        }
      }
    },
    propFix: {
      tabindex: "tabIndex",
      readonly: "readOnly",
      "for": "htmlFor",
      "class": "className",
      maxlength: "maxLength",
      cellspacing: "cellSpacing",
      cellpadding: "cellPadding",
      rowspan: "rowSpan",
      colspan: "colSpan",
      usemap: "useMap",
      frameborder: "frameBorder",
      contenteditable: "contentEditable"
    },
    prop: function(a, c, d) {
      var e, g, h, i = a.nodeType;
      if (!!a && i !== 3 && i !== 8 && i !== 2) {
        h = i !== 1 || !f.isXMLDoc(a), h && (c = f.propFix[c] || c, g = f.propHooks[c]);
        return d !== b ? g && "set" in g && (e = g.set(a, d, c)) !== b ? e : a[c] = d : g && "get" in g && (e = g.get(a, c)) !== null ? e : a[c]
      }
    },
    propHooks: {
      tabIndex: {
        get: function(a) {
          var c = a.getAttributeNode("tabindex");
          return c && c.specified ? parseInt(c.value, 10) : s.test(a.nodeName) || t.test(a.nodeName) && a.href ? 0 : b
        }
      }
    }
  }), f.attrHooks.tabindex = f.propHooks.tabIndex, x = {
    get: function(a, c) {
      var d, e = f.prop(a, c);
      return e === !0 || typeof e != "boolean" && (d = a.getAttributeNode(c)) && d.nodeValue !== !1 ? c.toLowerCase() : b
    },
    set: function(a, b, c) {
      var d;
      b === !1 ? f.removeAttr(a, c) : (d = f.propFix[c] || c, d in a && (a[d] = !0), a.setAttribute(c, c.toLowerCase()));
      return c
    }
  }, v || (y = {
    name: !0,
    id: !0
  }, w = f.valHooks.button = {
    get: function(a, c) {
      var d;
      d = a.getAttributeNode(c);
      return d && (y[c] ? d.nodeValue !== "" : d.specified) ? d.nodeValue : b
    },
    set: function(a, b, d) {
      var e = a.getAttributeNode(d);
      e || (e = c.createAttribute(d), a.setAttributeNode(e));
      return e.nodeValue = b + ""
    }
  }, f.attrHooks.tabindex.set = w.set, f.each(["width", "height"], function(a, b) {
    f.attrHooks[b] = f.extend(f.attrHooks[b], {
      set: function(a, c) {
        if (c === "") {
          a.setAttribute(b, "auto");
          return c
        }
      }
    })
  }), f.attrHooks.contenteditable = {
    get: w.get,
    set: function(a, b, c) {
      b === "" && (b = "false"), w.set(a, b, c)
    }
  }), f.support.hrefNormalized || f.each(["href", "src", "width", "height"], function(a, c) {
    f.attrHooks[c] = f.extend(f.attrHooks[c], {
      get: function(a) {
        var d = a.getAttribute(c, 2);
        return d === null ? b : d
      }
    })
  }), f.support.style || (f.attrHooks.style = {
    get: function(a) {
      return a.style.cssText.toLowerCase() || b
    },
    set: function(a, b) {
      return a.style.cssText = "" + b
    }
  }), f.support.optSelected || (f.propHooks.selected = f.extend(f.propHooks.selected, {
    get: function(a) {
      var b = a.parentNode;
      b && (b.selectedIndex, b.parentNode && b.parentNode.selectedIndex);
      return null
    }
  })), f.support.enctype || (f.propFix.enctype = "encoding"), f.support.checkOn || f.each(["radio", "checkbox"], function() {
    f.valHooks[this] = {
      get: function(a) {
        return a.getAttribute("value") === null ? "on" : a.value
      }
    }
  }), f.each(["radio", "checkbox"], function() {
    f.valHooks[this] = f.extend(f.valHooks[this], {
      set: function(a, b) {
        if (f.isArray(b)) return a.checked = f.inArray(f(a).val(), b) >= 0
      }
    })
  });
  var z = /^(?:textarea|input|select)$/i,
    A = /^([^\.]*)?(?:\.(.+))?$/,
    B = /\bhover(\.\S+)?\b/,
    C = /^key/,
    D = /^(?:mouse|contextmenu)|click/,
    E = /^(?:focusinfocus|focusoutblur)$/,
    F = /^(\w*)(?:#([\w\-]+))?(?:\.([\w\-]+))?$/,
    G = function(a) {
      var b = F.exec(a);
      b && (b[1] = (b[1] || "").toLowerCase(), b[3] = b[3] && new RegExp("(?:^|\\s)" + b[3] + "(?:\\s|$)"));
      return b
    },
    H = function(a, b) {
      var c = a.attributes || {};
      return (!b[1] || a.nodeName.toLowerCase() === b[1]) && (!b[2] || (c.id || {}).value === b[2]) && (!b[3] || b[3].test((c["class"] || {}).value))
    },
    I = function(a) {
      return f.event.special.hover ? a : a.replace(B, "mouseenter$1 mouseleave$1")
    };
  f.event = {
      add: function(a, c, d, e, g) {
        var h, i, j, k, l, m, n, o, p, q, r, s;
        if (!(a.nodeType === 3 || a.nodeType === 8 || !c || !d || !(h = f._data(a)))) {
          d.handler && (p = d, d = p.handler), d.guid || (d.guid = f.guid++), j = h.events, j || (h.events = j = {}), i = h.handle, i || (h.handle = i = function(a) {
            return typeof f != "undefined" && (!a || f.event.triggered !== a.type) ? f.event.dispatch.apply(i.elem, arguments) : b
          }, i.elem = a), c = f.trim(I(c)).split(" ");
          for (k = 0; k < c.length; k++) {
            l = A.exec(c[k]) || [], m = l[1], n = (l[2] || "").split(".").sort(), s = f.event.special[m] || {}, m = (g ? s.delegateType : s.bindType) || m, s = f.event.special[m] || {}, o = f.extend({
              type: m,
              origType: l[1],
              data: e,
              handler: d,
              guid: d.guid,
              selector: g,
              quick: G(g),
              namespace: n.join(".")
            }, p), r = j[m];
            if (!r) {
              r = j[m] = [], r.delegateCount = 0;
              if (!s.setup || s.setup.call(a, e, n, i) === !1) a.addEventListener ? a.addEventListener(m, i, !1) : a.attachEvent && a.attachEvent("on" + m, i)
            }
            s.add && (s.add.call(a, o), o.handler.guid || (o.handler.guid = d.guid)), g ? r.splice(r.delegateCount++, 0, o) : r.push(o), f.event.global[m] = !0
          }
          a = null
        }
      },
      global: {},
      remove: function(a, b, c, d, e) {
        var g = f.hasData(a) && f._data(a),
          h, i, j, k, l, m, n, o, p, q, r, s;
        if (!!g && !!(o = g.events)) {
          b = f.trim(I(b || "")).split(" ");
          for (h = 0; h < b.length; h++) {
            i = A.exec(b[h]) || [], j = k = i[1], l = i[2];
            if (!j) {
              for (j in o) f.event.remove(a, j + b[h], c, d, !0);
              continue
            }
            p = f.event.special[j] || {}, j = (d ? p.delegateType : p.bindType) || j, r = o[j] || [], m = r.length, l = l ? new RegExp("(^|\\.)" + l.split(".").sort().join("\\.(?:.*\\.)?") + "(\\.|$)") : null;
            for (n = 0; n < r.length; n++) s = r[n], (e || k === s.origType) && (!c || c.guid === s.guid) && (!l || l.test(s.namespace)) && (!d || d === s.selector || d === "**" && s.selector) && (r.splice(n--, 1), s.selector && r.delegateCount--, p.remove && p.remove.call(a, s));
            r.length === 0 && m !== r.length && ((!p.teardown || p.teardown.call(a, l) === !1) && f.removeEvent(a, j, g.handle), delete o[j])
          }
          f.isEmptyObject(o) && (q = g.handle, q && (q.elem = null), f.removeData(a, ["events", "handle"], !0))
        }
      },
      customEvent: {
        getData: !0,
        setData: !0,
        changeData: !0
      },
      trigger: function(c, d, e, g) {
        if (!e || e.nodeType !== 3 && e.nodeType !== 8) {
          var h = c.type || c,
            i = [],
            j, k, l, m, n, o, p, q, r, s;
          if (E.test(h + f.event.triggered)) return;
          h.indexOf("!") >= 0 && (h = h.slice(0, -1), k = !0), h.indexOf(".") >= 0 && (i = h.split("."), h = i.shift(), i.sort());
          if ((!e || f.event.customEvent[h]) && !f.event.global[h]) return;
          c = typeof c == "object" ? c[f.expando] ? c : new f.Event(h, c) : new f.Event(h), c.type = h, c.isTrigger = !0, c.exclusive = k, c.namespace = i.join("."), c.namespace_re = c.namespace ? new RegExp("(^|\\.)" + i.join("\\.(?:.*\\.)?") + "(\\.|$)") : null, o = h.indexOf(":") < 0 ? "on" + h : "";
          if (!e) {
            j = f.cache;
            for (l in j) j[l].events && j[l].events[h] && f.event.trigger(c, d, j[l].handle.elem, !0);
            return
          }
          c.result = b, c.target || (c.target = e), d = d != null ? f.makeArray(d) : [], d.unshift(c), p = f.event.special[h] || {};
          if (p.trigger && p.trigger.apply(e, d) === !1) return;
          r = [
            [e, p.bindType || h]
          ];
          if (!g && !p.noBubble && !f.isWindow(e)) {
            s = p.delegateType || h, m = E.test(s + h) ? e : e.parentNode, n = null;
            for (; m; m = m.parentNode) r.push([m, s]), n = m;
            n && n === e.ownerDocument && r.push([n.defaultView || n.parentWindow || a, s])
          }
          for (l = 0; l < r.length && !c.isPropagationStopped(); l++) m = r[l][0], c.type = r[l][1], q = (f._data(m, "events") || {})[c.type] && f._data(m, "handle"), q && q.apply(m, d), q = o && m[o], q && f.acceptData(m) && q.apply(m, d) === !1 && c.preventDefault();
          c.type = h, !g && !c.isDefaultPrevented() && (!p._default || p._default.apply(e.ownerDocument, d) === !1) && (h !== "click" || !f.nodeName(e, "a")) && f.acceptData(e) && o && e[h] && (h !== "focus" && h !== "blur" || c.target.offsetWidth !== 0) && !f.isWindow(e) && (n = e[o], n && (e[o] = null), f.event.triggered = h, e[h](), f.event.triggered = b, n && (e[o] = n));
          return c.result
        }
      },
      dispatch: function(c) {
        c = f.event.fix(c || a.event);
        var d = (f._data(this, "events") || {})[c.type] || [],
          e = d.delegateCount,
          g = [].slice.call(arguments, 0),
          h = !c.exclusive && !c.namespace,
          i = [],
          j, k, l, m, n, o, p, q, r, s, t;
        g[0] = c, c.delegateTarget = this;
        if (e && !c.target.disabled && (!c.button || c.type !== "click")) {
          m = f(this), m.context = this.ownerDocument || this;
          for (l = c.target; l != this; l = l.parentNode || this) {
            o = {}, q = [], m[0] = l;
            for (j = 0; j < e; j++) r = d[j], s = r.selector, o[s] === b && (o[s] = r.quick ? H(l, r.quick) : m.is(s)), o[s] && q.push(r);
            q.length && i.push({
              elem: l,
              matches: q
            })
          }
        }
        d.length > e && i.push({
          elem: this,
          matches: d.slice(e)
        });
        for (j = 0; j < i.length && !c.isPropagationStopped(); j++) {
          p = i[j], c.currentTarget = p.elem;
          for (k = 0; k < p.matches.length && !c.isImmediatePropagationStopped(); k++) {
            r = p.matches[k];
            if (h || !c.namespace && !r.namespace || c.namespace_re && c.namespace_re.test(r.namespace)) c.data = r.data, c.handleObj = r, n = ((f.event.special[r.origType] || {}).handle || r.handler).apply(p.elem, g), n !== b && (c.result = n, n === !1 && (c.preventDefault(), c.stopPropagation()))
          }
        }
        return c.result
      },
      props: "attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
      fixHooks: {},
      keyHooks: {
        props: "char charCode key keyCode".split(" "),
        filter: function(a, b) {
          a.which == null && (a.which = b.charCode != null ? b.charCode : b.keyCode);
          return a
        }
      },
      mouseHooks: {
        props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
        filter: function(a, d) {
          var e, f, g, h = d.button,
            i = d.fromElement;
          a.pageX == null && d.clientX != null && (e = a.target.ownerDocument || c, f = e.documentElement, g = e.body, a.pageX = d.clientX + (f && f.scrollLeft || g && g.scrollLeft || 0) - (f && f.clientLeft || g && g.clientLeft || 0), a.pageY = d.clientY + (f && f.scrollTop || g && g.scrollTop || 0) - (f && f.clientTop || g && g.clientTop || 0)), !a.relatedTarget && i && (a.relatedTarget = i === a.target ? d.toElement : i), !a.which && h !== b && (a.which = h & 1 ? 1 : h & 2 ? 3 : h & 4 ? 2 : 0);
          return a
        }
      },
      fix: function(a) {
        if (a[f.expando]) return a;
        var d, e, g = a,
          h = f.event.fixHooks[a.type] || {},
          i = h.props ? this.props.concat(h.props) : this.props;
        a = f.Event(g);
        for (d = i.length; d;) e = i[--d], a[e] = g[e];
        a.target || (a.target = g.srcElement || c), a.target.nodeType === 3 && (a.target = a.target.parentNode), a.metaKey === b && (a.metaKey = a.ctrlKey);
        return h.filter ? h.filter(a, g) : a
      },
      special: {
        ready: {
          setup: f.bindReady
        },
        load: {
          noBubble: !0
        },
        focus: {
          delegateType: "focusin"
        },
        blur: {
          delegateType: "focusout"
        },
        beforeunload: {
          setup: function(a, b, c) {
            f.isWindow(this) && (this.onbeforeunload = c)
          },
          teardown: function(a, b) {
            this.onbeforeunload === b && (this.onbeforeunload = null)
          }
        }
      },
      simulate: function(a, b, c, d) {
        var e = f.extend(new f.Event, c, {
          type: a,
          isSimulated: !0,
          originalEvent: {}
        });
        d ? f.event.trigger(e, null, b) : f.event.dispatch.call(b, e), e.isDefaultPrevented() && c.preventDefault()
      }
    }, f.event.handle = f.event.dispatch, f.removeEvent = c.removeEventListener ? function(a, b, c) {
      a.removeEventListener && a.removeEventListener(b, c, !1)
    } : function(a, b, c) {
      a.detachEvent && a.detachEvent("on" + b, c)
    }, f.Event = function(a, b) {
      if (!(this instanceof f.Event)) return new f.Event(a, b);
      a && a.type ? (this.originalEvent = a, this.type = a.type, this.isDefaultPrevented = a.defaultPrevented || a.returnValue === !1 || a.getPreventDefault && a.getPreventDefault() ? K : J) : this.type = a, b && f.extend(this, b), this.timeStamp = a && a.timeStamp || f.now(), this[f.expando] = !0
    }, f.Event.prototype = {
      preventDefault: function() {
        this.isDefaultPrevented = K;
        var a = this.originalEvent;
        !a || (a.preventDefault ? a.preventDefault() : a.returnValue = !1)
      },
      stopPropagation: function() {
        this.isPropagationStopped = K;
        var a = this.originalEvent;
        !a || (a.stopPropagation && a.stopPropagation(), a.cancelBubble = !0)
      },
      stopImmediatePropagation: function() {
        this.isImmediatePropagationStopped = K, this.stopPropagation()
      },
      isDefaultPrevented: J,
      isPropagationStopped: J,
      isImmediatePropagationStopped: J
    }, f.each({
      mouseenter: "mouseover",
      mouseleave: "mouseout"
    }, function(a, b) {
      f.event.special[a] = {
        delegateType: b,
        bindType: b,
        handle: function(a) {
          var c = this,
            d = a.relatedTarget,
            e = a.handleObj,
            g = e.selector,
            h;
          if (!d || d !== c && !f.contains(c, d)) a.type = e.origType, h = e.handler.apply(this, arguments), a.type = b;
          return h
        }
      }
    }), f.support.submitBubbles || (f.event.special.submit = {
      setup: function() {
        if (f.nodeName(this, "form")) return !1;
        f.event.add(this, "click._submit keypress._submit", function(a) {
          var c = a.target,
            d = f.nodeName(c, "input") || f.nodeName(c, "button") ? c.form : b;
          d && !d._submit_attached && (f.event.add(d, "submit._submit", function(a) {
            this.parentNode && !a.isTrigger && f.event.simulate("submit", this.parentNode, a, !0)
          }), d._submit_attached = !0)
        })
      },
      teardown: function() {
        if (f.nodeName(this, "form")) return !1;
        f.event.remove(this, "._submit")
      }
    }), f.support.changeBubbles || (f.event.special.change = {
      setup: function() {
        if (z.test(this.nodeName)) {
          if (this.type === "checkbox" || this.type === "radio") f.event.add(this, "propertychange._change", function(a) {
            a.originalEvent.propertyName === "checked" && (this._just_changed = !0)
          }), f.event.add(this, "click._change", function(a) {
            this._just_changed && !a.isTrigger && (this._just_changed = !1, f.event.simulate("change", this, a, !0))
          });
          return !1
        }
        f.event.add(this, "beforeactivate._change", function(a) {
          var b = a.target;
          z.test(b.nodeName) && !b._change_attached && (f.event.add(b, "change._change", function(a) {
            this.parentNode && !a.isSimulated && !a.isTrigger && f.event.simulate("change", this.parentNode, a, !0)
          }), b._change_attached = !0)
        })
      },
      handle: function(a) {
        var b = a.target;
        if (this !== b || a.isSimulated || a.isTrigger || b.type !== "radio" && b.type !== "checkbox") return a.handleObj.handler.apply(this, arguments)
      },
      teardown: function() {
        f.event.remove(this, "._change");
        return z.test(this.nodeName)
      }
    }), f.support.focusinBubbles || f.each({
      focus: "focusin",
      blur: "focusout"
    }, function(a, b) {
      var d = 0,
        e = function(a) {
          f.event.simulate(b, a.target, f.event.fix(a), !0)
        };
      f.event.special[b] = {
        setup: function() {
          d++ === 0 && c.addEventListener(a, e, !0)
        },
        teardown: function() {
          --d === 0 && c.removeEventListener(a, e, !0)
        }
      }
    }), f.fn.extend({
      on: function(a, c, d, e, g) {
        var h, i;
        if (typeof a == "object") {
          typeof c != "string" && (d = c, c = b);
          for (i in a) this.on(i, c, d, a[i], g);
          return this
        }
        d == null && e == null ? (e = c, d = c = b) : e == null && (typeof c == "string" ? (e = d, d = b) : (e = d, d = c, c = b));
        if (e === !1) e = J;
        else if (!e) return this;
        g === 1 && (h = e, e = function(a) {
          f().off(a);
          return h.apply(this, arguments)
        }, e.guid = h.guid || (h.guid = f.guid++));
        return this.each(function() {
          f.event.add(this, a, e, d, c)
        })
      },
      one: function(a, b, c, d) {
        return this.on.call(this, a, b, c, d, 1)
      },
      off: function(a, c, d) {
        if (a && a.preventDefault && a.handleObj) {
          var e = a.handleObj;
          f(a.delegateTarget).off(e.namespace ? e.type + "." + e.namespace : e.type, e.selector, e.handler);
          return this
        }
        if (typeof a == "object") {
          for (var g in a) this.off(g, c, a[g]);
          return this
        }
        if (c === !1 || typeof c == "function") d = c, c = b;
        d === !1 && (d = J);
        return this.each(function() {
          f.event.remove(this, a, d, c)
        })
      },
      bind: function(a, b, c) {
        return this.on(a, null, b, c)
      },
      unbind: function(a, b) {
        return this.off(a, null, b)
      },
      live: function(a, b, c) {
        f(this.context).on(a, this.selector, b, c);
        return this
      },
      die: function(a, b) {
        f(this.context).off(a, this.selector || "**", b);
        return this
      },
      delegate: function(a, b, c, d) {
        return this.on(b, a, c, d)
      },
      undelegate: function(a, b, c) {
        return arguments.length == 1 ? this.off(a, "**") : this.off(b, a, c)
      },
      trigger: function(a, b) {
        return this.each(function() {
          f.event.trigger(a, b, this)
        })
      },
      triggerHandler: function(a, b) {
        if (this[0]) return f.event.trigger(a, b, this[0], !0)
      },
      toggle: function(a) {
        var b = arguments,
          c = a.guid || f.guid++,
          d = 0,
          e = function(c) {
            var e = (f._data(this, "lastToggle" + a.guid) || 0) % d;
            f._data(this, "lastToggle" + a.guid, e + 1), c.preventDefault();
            return b[e].apply(this, arguments) || !1
          };
        e.guid = c;
        while (d < b.length) b[d++].guid = c;
        return this.click(e)
      },
      hover: function(a, b) {
        return this.mouseenter(a).mouseleave(b || a)
      }
    }), f.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(a, b) {
      f.fn[b] = function(a, c) {
        c == null && (c = a, a = null);
        return arguments.length > 0 ? this.on(b, null, a, c) : this.trigger(b)
      }, f.attrFn && (f.attrFn[b] = !0), C.test(b) && (f.event.fixHooks[b] = f.event.keyHooks), D.test(b) && (f.event.fixHooks[b] = f.event.mouseHooks)
    }),
    function() {
      function x(a, b, c, e, f, g) {
        for (var h = 0, i = e.length; h < i; h++) {
          var j = e[h];
          if (j) {
            var k = !1;
            j = j[a];
            while (j) {
              if (j[d] === c) {
                k = e[j.sizset];
                break
              }
              if (j.nodeType === 1) {
                g || (j[d] = c, j.sizset = h);
                if (typeof b != "string") {
                  if (j === b) {
                    k = !0;
                    break
                  }
                } else if (m.filter(b, [j]).length > 0) {
                  k = j;
                  break
                }
              }
              j = j[a]
            }
            e[h] = k
          }
        }
      }

      function w(a, b, c, e, f, g) {
        for (var h = 0, i = e.length; h < i; h++) {
          var j = e[h];
          if (j) {
            var k = !1;
            j = j[a];
            while (j) {
              if (j[d] === c) {
                k = e[j.sizset];
                break
              }
              j.nodeType === 1 && !g && (j[d] = c, j.sizset = h);
              if (j.nodeName.toLowerCase() === b) {
                k = j;
                break
              }
              j = j[a]
            }
            e[h] = k
          }
        }
      }
      var a = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,
        d = "sizcache" + (Math.random() + "").replace(".", ""),
        e = 0,
        g = Object.prototype.toString,
        h = !1,
        i = !0,
        j = /\\/g,
        k = /\r\n/g,
        l = /\W/;
      [0, 0].sort(function() {
        i = !1;
        return 0
      });
      var m = function(b, d, e, f) {
        e = e || [], d = d || c;
        var h = d;
        if (d.nodeType !== 1 && d.nodeType !== 9) return [];
        if (!b || typeof b != "string") return e;
        var i, j, k, l, n, q, r, t, u = !0,
          v = m.isXML(d),
          w = [],
          x = b;
        do {
          a.exec(""), i = a.exec(x);
          if (i) {
            x = i[3], w.push(i[1]);
            if (i[2]) {
              l = i[3];
              break
            }
          }
        } while (i);
        if (w.length > 1 && p.exec(b))
          if (w.length === 2 && o.relative[w[0]]) j = y(w[0] + w[1], d, f);
          else {
            j = o.relative[w[0]] ? [d] : m(w.shift(), d);
            while (w.length) b = w.shift(), o.relative[b] && (b += w.shift()), j = y(b, j, f)
          } else {
          !f && w.length > 1 && d.nodeType === 9 && !v && o.match.ID.test(w[0]) && !o.match.ID.test(w[w.length - 1]) && (n = m.find(w.shift(), d, v), d = n.expr ? m.filter(n.expr, n.set)[0] : n.set[0]);
          if (d) {
            n = f ? {
              expr: w.pop(),
              set: s(f)
            } : m.find(w.pop(), w.length === 1 && (w[0] === "~" || w[0] === "+") && d.parentNode ? d.parentNode : d, v), j = n.expr ? m.filter(n.expr, n.set) : n.set, w.length > 0 ? k = s(j) : u = !1;
            while (w.length) q = w.pop(), r = q, o.relative[q] ? r = w.pop() : q = "", r == null && (r = d), o.relative[q](k, r, v)
          } else k = w = []
        }
        k || (k = j), k || m.error(q || b);
        if (g.call(k) === "[object Array]")
          if (!u) e.push.apply(e, k);
          else if (d && d.nodeType === 1)
          for (t = 0; k[t] != null; t++) k[t] && (k[t] === !0 || k[t].nodeType === 1 && m.contains(d, k[t])) && e.push(j[t]);
        else
          for (t = 0; k[t] != null; t++) k[t] && k[t].nodeType === 1 && e.push(j[t]);
        else s(k, e);
        l && (m(l, h, e, f), m.uniqueSort(e));
        return e
      };
      m.uniqueSort = function(a) {
        if (u) {
          h = i, a.sort(u);
          if (h)
            for (var b = 1; b < a.length; b++) a[b] === a[b - 1] && a.splice(b--, 1)
        }
        return a
      }, m.matches = function(a, b) {
        return m(a, null, null, b)
      }, m.matchesSelector = function(a, b) {
        return m(b, null, null, [a]).length > 0
      }, m.find = function(a, b, c) {
        var d, e, f, g, h, i;
        if (!a) return [];
        for (e = 0, f = o.order.length; e < f; e++) {
          h = o.order[e];
          if (g = o.leftMatch[h].exec(a)) {
            i = g[1], g.splice(1, 1);
            if (i.substr(i.length - 1) !== "\\") {
              g[1] = (g[1] || "").replace(j, ""), d = o.find[h](g, b, c);
              if (d != null) {
                a = a.replace(o.match[h], "");
                break
              }
            }
          }
        }
        d || (d = typeof b.getElementsByTagName != "undefined" ? b.getElementsByTagName("*") : []);
        return {
          set: d,
          expr: a
        }
      }, m.filter = function(a, c, d, e) {
        var f, g, h, i, j, k, l, n, p, q = a,
          r = [],
          s = c,
          t = c && c[0] && m.isXML(c[0]);
        while (a && c.length) {
          for (h in o.filter)
            if ((f = o.leftMatch[h].exec(a)) != null && f[2]) {
              k = o.filter[h], l = f[1], g = !1, f.splice(1, 1);
              if (l.substr(l.length - 1) === "\\") continue;
              s === r && (r = []);
              if (o.preFilter[h]) {
                f = o.preFilter[h](f, s, d, r, e, t);
                if (!f) g = i = !0;
                else if (f === !0) continue
              }
              if (f)
                for (n = 0;
                  (j = s[n]) != null; n++) j && (i = k(j, f, n, s), p = e ^ i, d && i != null ? p ? g = !0 : s[n] = !1 : p && (r.push(j), g = !0));
              if (i !== b) {
                d || (s = r), a = a.replace(o.match[h], "");
                if (!g) return [];
                break
              }
            }
          if (a === q)
            if (g == null) m.error(a);
            else break;
          q = a
        }
        return s
      }, m.error = function(a) {
        throw new Error("Syntax error, unrecognized expression: " + a)
      };
      var n = m.getText = function(a) {
          var b, c, d = a.nodeType,
            e = "";
          if (d) {
            if (d === 1 || d === 9) {
              if (typeof a.textContent == "string") return a.textContent;
              if (typeof a.innerText == "string") return a.innerText.replace(k, "");
              for (a = a.firstChild; a; a = a.nextSibling) e += n(a)
            } else if (d === 3 || d === 4) return a.nodeValue
          } else
            for (b = 0; c = a[b]; b++) c.nodeType !== 8 && (e += n(c));
          return e
        },
        o = m.selectors = {
          order: ["ID", "NAME", "TAG"],
          match: {
            ID: /#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
            CLASS: /\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
            NAME: /\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,
            ATTR: /\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(?:(['"])(.*?)\3|(#?(?:[\w\u00c0-\uFFFF\-]|\\.)*)|)|)\s*\]/,
            TAG: /^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,
            CHILD: /:(only|nth|last|first)-child(?:\(\s*(even|odd|(?:[+\-]?\d+|(?:[+\-]?\d*)?n\s*(?:[+\-]\s*\d+)?))\s*\))?/,
            POS: /:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,
            PSEUDO: /:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/
          },
          leftMatch: {},
          attrMap: {
            "class": "className",
            "for": "htmlFor"
          },
          attrHandle: {
            href: function(a) {
              return a.getAttribute("href")
            },
            type: function(a) {
              return a.getAttribute("type")
            }
          },
          relative: {
            "+": function(a, b) {
              var c = typeof b == "string",
                d = c && !l.test(b),
                e = c && !d;
              d && (b = b.toLowerCase());
              for (var f = 0, g = a.length, h; f < g; f++)
                if (h = a[f]) {
                  while ((h = h.previousSibling) && h.nodeType !== 1);
                  a[f] = e || h && h.nodeName.toLowerCase() === b ? h || !1 : h === b
                }
              e && m.filter(b, a, !0)
            },
            ">": function(a, b) {
              var c, d = typeof b == "string",
                e = 0,
                f = a.length;
              if (d && !l.test(b)) {
                b = b.toLowerCase();
                for (; e < f; e++) {
                  c = a[e];
                  if (c) {
                    var g = c.parentNode;
                    a[e] = g.nodeName.toLowerCase() === b ? g : !1
                  }
                }
              } else {
                for (; e < f; e++) c = a[e], c && (a[e] = d ? c.parentNode : c.parentNode === b);
                d && m.filter(b, a, !0)
              }
            },
            "": function(a, b, c) {
              var d, f = e++,
                g = x;
              typeof b == "string" && !l.test(b) && (b = b.toLowerCase(), d = b, g = w), g("parentNode", b, f, a, d, c)
            },
            "~": function(a, b, c) {
              var d, f = e++,
                g = x;
              typeof b == "string" && !l.test(b) && (b = b.toLowerCase(), d = b, g = w), g("previousSibling", b, f, a, d, c)
            }
          },
          find: {
            ID: function(a, b, c) {
              if (typeof b.getElementById != "undefined" && !c) {
                var d = b.getElementById(a[1]);
                return d && d.parentNode ? [d] : []
              }
            },
            NAME: function(a, b) {
              if (typeof b.getElementsByName != "undefined") {
                var c = [],
                  d = b.getElementsByName(a[1]);
                for (var e = 0, f = d.length; e < f; e++) d[e].getAttribute("name") === a[1] && c.push(d[e]);
                return c.length === 0 ? null : c
              }
            },
            TAG: function(a, b) {
              if (typeof b.getElementsByTagName != "undefined") return b.getElementsByTagName(a[1])
            }
          },
          preFilter: {
            CLASS: function(a, b, c, d, e, f) {
              a = " " + a[1].replace(j, "") + " ";
              if (f) return a;
              for (var g = 0, h;
                (h = b[g]) != null; g++) h && (e ^ (h.className && (" " + h.className + " ").replace(/[\t\n\r]/g, " ").indexOf(a) >= 0) ? c || d.push(h) : c && (b[g] = !1));
              return !1
            },
            ID: function(a) {
              return a[1].replace(j, "")
            },
            TAG: function(a, b) {
              return a[1].replace(j, "").toLowerCase()
            },
            CHILD: function(a) {
              if (a[1] === "nth") {
                a[2] || m.error(a[0]), a[2] = a[2].replace(/^\+|\s*/g, "");
                var b = /(-?)(\d*)(?:n([+\-]?\d*))?/.exec(a[2] === "even" && "2n" || a[2] === "odd" && "2n+1" || !/\D/.test(a[2]) && "0n+" + a[2] || a[2]);
                a[2] = b[1] + (b[2] || 1) - 0, a[3] = b[3] - 0
              } else a[2] && m.error(a[0]);
              a[0] = e++;
              return a
            },
            ATTR: function(a, b, c, d, e, f) {
              var g = a[1] = a[1].replace(j, "");
              !f && o.attrMap[g] && (a[1] = o.attrMap[g]), a[4] = (a[4] || a[5] || "").replace(j, ""), a[2] === "~=" && (a[4] = " " + a[4] + " ");
              return a
            },
            PSEUDO: function(b, c, d, e, f) {
              if (b[1] === "not")
                if ((a.exec(b[3]) || "").length > 1 || /^\w/.test(b[3])) b[3] = m(b[3], null, null, c);
                else {
                  var g = m.filter(b[3], c, d, !0 ^ f);
                  d || e.push.apply(e, g);
                  return !1
                } else if (o.match.POS.test(b[0]) || o.match.CHILD.test(b[0])) return !0;
              return b
            },
            POS: function(a) {
              a.unshift(!0);
              return a
            }
          },
          filters: {
            enabled: function(a) {
              return a.disabled === !1 && a.type !== "hidden"
            },
            disabled: function(a) {
              return a.disabled === !0
            },
            checked: function(a) {
              return a.checked === !0
            },
            selected: function(a) {
              a.parentNode && a.parentNode.selectedIndex;
              return a.selected === !0
            },
            parent: function(a) {
              return !!a.firstChild
            },
            empty: function(a) {
              return !a.firstChild
            },
            has: function(a, b, c) {
              return !!m(c[3], a).length
            },
            header: function(a) {
              return /h\d/i.test(a.nodeName)
            },
            text: function(a) {
              var b = a.getAttribute("type"),
                c = a.type;
              return a.nodeName.toLowerCase() === "input" && "text" === c && (b === c || b === null)
            },
            radio: function(a) {
              return a.nodeName.toLowerCase() === "input" && "radio" === a.type
            },
            checkbox: function(a) {
              return a.nodeName.toLowerCase() === "input" && "checkbox" === a.type
            },
            file: function(a) {
              return a.nodeName.toLowerCase() === "input" && "file" === a.type
            },
            password: function(a) {
              return a.nodeName.toLowerCase() === "input" && "password" === a.type
            },
            submit: function(a) {
              var b = a.nodeName.toLowerCase();
              return (b === "input" || b === "button") && "submit" === a.type
            },
            image: function(a) {
              return a.nodeName.toLowerCase() === "input" && "image" === a.type
            },
            reset: function(a) {
              var b = a.nodeName.toLowerCase();
              return (b === "input" || b === "button") && "reset" === a.type
            },
            button: function(a) {
              var b = a.nodeName.toLowerCase();
              return b === "input" && "button" === a.type || b === "button"
            },
            input: function(a) {
              return /input|select|textarea|button/i.test(a.nodeName)
            },
            focus: function(a) {
              return a === a.ownerDocument.activeElement
            }
          },
          setFilters: {
            first: function(a, b) {
              return b === 0
            },
            last: function(a, b, c, d) {
              return b === d.length - 1
            },
            even: function(a, b) {
              return b % 2 === 0
            },
            odd: function(a, b) {
              return b % 2 === 1
            },
            lt: function(a, b, c) {
              return b < c[3] - 0
            },
            gt: function(a, b, c) {
              return b > c[3] - 0
            },
            nth: function(a, b, c) {
              return c[3] - 0 === b
            },
            eq: function(a, b, c) {
              return c[3] - 0 === b
            }
          },
          filter: {
            PSEUDO: function(a, b, c, d) {
              var e = b[1],
                f = o.filters[e];
              if (f) return f(a, c, b, d);
              if (e === "contains") return (a.textContent || a.innerText || n([a]) || "").indexOf(b[3]) >= 0;
              if (e === "not") {
                var g = b[3];
                for (var h = 0, i = g.length; h < i; h++)
                  if (g[h] === a) return !1;
                return !0
              }
              m.error(e)
            },
            CHILD: function(a, b) {
              var c, e, f, g, h, i, j, k = b[1],
                l = a;
              switch (k) {
                case "only":
                case "first":
                  while (l = l.previousSibling)
                    if (l.nodeType === 1) return !1;
                  if (k === "first") return !0;
                  l = a;
                case "last":
                  while (l = l.nextSibling)
                    if (l.nodeType === 1) return !1;
                  return !0;
                case "nth":
                  c = b[2], e = b[3];
                  if (c === 1 && e === 0) return !0;
                  f = b[0], g = a.parentNode;
                  if (g && (g[d] !== f || !a.nodeIndex)) {
                    i = 0;
                    for (l = g.firstChild; l; l = l.nextSibling) l.nodeType === 1 && (l.nodeIndex = ++i);
                    g[d] = f
                  }
                  j = a.nodeIndex - e;
                  return c === 0 ? j === 0 : j % c === 0 && j / c >= 0
              }
            },
            ID: function(a, b) {
              return a.nodeType === 1 && a.getAttribute("id") === b
            },
            TAG: function(a, b) {
              return b === "*" && a.nodeType === 1 || !!a.nodeName && a.nodeName.toLowerCase() === b
            },
            CLASS: function(a, b) {
              return (" " + (a.className || a.getAttribute("class")) + " ").indexOf(b) > -1
            },
            ATTR: function(a, b) {
              var c = b[1],
                d = m.attr ? m.attr(a, c) : o.attrHandle[c] ? o.attrHandle[c](a) : a[c] != null ? a[c] : a.getAttribute(c),
                e = d + "",
                f = b[2],
                g = b[4];
              return d == null ? f === "!=" : !f && m.attr ? d != null : f === "=" ? e === g : f === "*=" ? e.indexOf(g) >= 0 : f === "~=" ? (" " + e + " ").indexOf(g) >= 0 : g ? f === "!=" ? e !== g : f === "^=" ? e.indexOf(g) === 0 : f === "$=" ? e.substr(e.length - g.length) === g : f === "|=" ? e === g || e.substr(0, g.length + 1) === g + "-" : !1 : e && d !== !1
            },
            POS: function(a, b, c, d) {
              var e = b[2],
                f = o.setFilters[e];
              if (f) return f(a, c, b, d)
            }
          }
        },
        p = o.match.POS,
        q = function(a, b) {
          return "\\" + (b - 0 + 1)
        };
      for (var r in o.match) o.match[r] = new RegExp(o.match[r].source + /(?![^\[]*\])(?![^\(]*\))/.source), o.leftMatch[r] = new RegExp(/(^(?:.|\r|\n)*?)/.source + o.match[r].source.replace(/\\(\d+)/g, q));
      var s = function(a, b) {
        a = Array.prototype.slice.call(a, 0);
        if (b) {
          b.push.apply(b, a);
          return b
        }
        return a
      };
      try {
        Array.prototype.slice.call(c.documentElement.childNodes, 0)[0].nodeType
      } catch (t) {
        s = function(a, b) {
          var c = 0,
            d = b || [];
          if (g.call(a) === "[object Array]") Array.prototype.push.apply(d, a);
          else if (typeof a.length == "number")
            for (var e = a.length; c < e; c++) d.push(a[c]);
          else
            for (; a[c]; c++) d.push(a[c]);
          return d
        }
      }
      var u, v;
      c.documentElement.compareDocumentPosition ? u = function(a, b) {
          if (a === b) {
            h = !0;
            return 0
          }
          if (!a.compareDocumentPosition || !b.compareDocumentPosition) return a.compareDocumentPosition ? -1 : 1;
          return a.compareDocumentPosition(b) & 4 ? -1 : 1
        } : (u = function(a, b) {
          if (a === b) {
            h = !0;
            return 0
          }
          if (a.sourceIndex && b.sourceIndex) return a.sourceIndex - b.sourceIndex;
          var c, d, e = [],
            f = [],
            g = a.parentNode,
            i = b.parentNode,
            j = g;
          if (g === i) return v(a, b);
          if (!g) return -1;
          if (!i) return 1;
          while (j) e.unshift(j), j = j.parentNode;
          j = i;
          while (j) f.unshift(j), j = j.parentNode;
          c = e.length, d = f.length;
          for (var k = 0; k < c && k < d; k++)
            if (e[k] !== f[k]) return v(e[k], f[k]);
          return k === c ? v(a, f[k], -1) : v(e[k], b, 1)
        }, v = function(a, b, c) {
          if (a === b) return c;
          var d = a.nextSibling;
          while (d) {
            if (d === b) return -1;
            d = d.nextSibling
          }
          return 1
        }),
        function() {
          var a = c.createElement("div"),
            d = "script" + (new Date).getTime(),
            e = c.documentElement;
          a.innerHTML = "<a name='" + d + "'/>", e.insertBefore(a, e.firstChild), c.getElementById(d) && (o.find.ID = function(a, c, d) {
            if (typeof c.getElementById != "undefined" && !d) {
              var e = c.getElementById(a[1]);
              return e ? e.id === a[1] || typeof e.getAttributeNode != "undefined" && e.getAttributeNode("id").nodeValue === a[1] ? [e] : b : []
            }
          }, o.filter.ID = function(a, b) {
            var c = typeof a.getAttributeNode != "undefined" && a.getAttributeNode("id");
            return a.nodeType === 1 && c && c.nodeValue === b
          }), e.removeChild(a), e = a = null
        }(),
        function() {
          var a = c.createElement("div");
          a.appendChild(c.createComment("")), a.getElementsByTagName("*").length > 0 && (o.find.TAG = function(a, b) {
            var c = b.getElementsByTagName(a[1]);
            if (a[1] === "*") {
              var d = [];
              for (var e = 0; c[e]; e++) c[e].nodeType === 1 && d.push(c[e]);
              c = d
            }
            return c
          }), a.innerHTML = "<a href='#'></a>", a.firstChild && typeof a.firstChild.getAttribute != "undefined" && a.firstChild.getAttribute("href") !== "#" && (o.attrHandle.href = function(a) {
            return a.getAttribute("href", 2)
          }), a = null
        }(), c.querySelectorAll && function() {
          var a = m,
            b = c.createElement("div"),
            d = "__sizzle__";
          b.innerHTML = "<p class='TEST'></p>";
          if (!b.querySelectorAll || b.querySelectorAll(".TEST").length !== 0) {
            m = function(b, e, f, g) {
              e = e || c;
              if (!g && !m.isXML(e)) {
                var h = /^(\w+$)|^\.([\w\-]+$)|^#([\w\-]+$)/.exec(b);
                if (h && (e.nodeType === 1 || e.nodeType === 9)) {
                  if (h[1]) return s(e.getElementsByTagName(b), f);
                  if (h[2] && o.find.CLASS && e.getElementsByClassName) return s(e.getElementsByClassName(h[2]), f)
                }
                if (e.nodeType === 9) {
                  if (b === "body" && e.body) return s([e.body], f);
                  if (h && h[3]) {
                    var i = e.getElementById(h[3]);
                    if (!i || !i.parentNode) return s([], f);
                    if (i.id === h[3]) return s([i], f)
                  }
                  try {
                    return s(e.querySelectorAll(b), f)
                  } catch (j) {}
                } else if (e.nodeType === 1 && e.nodeName.toLowerCase() !== "object") {
                  var k = e,
                    l = e.getAttribute("id"),
                    n = l || d,
                    p = e.parentNode,
                    q = /^\s*[+~]/.test(b);
                  l ? n = n.replace(/'/g, "\\$&") : e.setAttribute("id", n), q && p && (e = e.parentNode);
                  try {
                    if (!q || p) return s(e.querySelectorAll("[id='" + n + "'] " + b), f)
                  } catch (r) {} finally {
                    l || k.removeAttribute("id")
                  }
                }
              }
              return a(b, e, f, g)
            };
            for (var e in a) m[e] = a[e];
            b = null
          }
        }(),
        function() {
          var a = c.documentElement,
            b = a.matchesSelector || a.mozMatchesSelector || a.webkitMatchesSelector || a.msMatchesSelector;
          if (b) {
            var d = !b.call(c.createElement("div"), "div"),
              e = !1;
            try {
              b.call(c.documentElement, "[test!='']:sizzle")
            } catch (f) {
              e = !0
            }
            m.matchesSelector = function(a, c) {
              c = c.replace(/\=\s*([^'"\]]*)\s*\]/g, "='$1']");
              if (!m.isXML(a)) try {
                if (e || !o.match.PSEUDO.test(c) && !/!=/.test(c)) {
                  var f = b.call(a, c);
                  if (f || !d || a.document && a.document.nodeType !== 11) return f
                }
              } catch (g) {}
              return m(c, null, null, [a]).length > 0
            }
          }
        }(),
        function() {
          var a = c.createElement("div");
          a.innerHTML = "<div class='test e'></div><div class='test'></div>";
          if (!!a.getElementsByClassName && a.getElementsByClassName("e").length !== 0) {
            a.lastChild.className = "e";
            if (a.getElementsByClassName("e").length === 1) return;
            o.order.splice(1, 0, "CLASS"), o.find.CLASS = function(a, b, c) {
              if (typeof b.getElementsByClassName != "undefined" && !c) return b.getElementsByClassName(a[1])
            }, a = null
          }
        }(), c.documentElement.contains ? m.contains = function(a, b) {
          return a !== b && (a.contains ? a.contains(b) : !0)
        } : c.documentElement.compareDocumentPosition ? m.contains = function(a, b) {
          return !!(a.compareDocumentPosition(b) & 16)
        } : m.contains = function() {
          return !1
        }, m.isXML = function(a) {
          var b = (a ? a.ownerDocument || a : 0).documentElement;
          return b ? b.nodeName !== "HTML" : !1
        };
      var y = function(a, b, c) {
        var d, e = [],
          f = "",
          g = b.nodeType ? [b] : b;
        while (d = o.match.PSEUDO.exec(a)) f += d[0], a = a.replace(o.match.PSEUDO, "");
        a = o.relative[a] ? a + "*" : a;
        for (var h = 0, i = g.length; h < i; h++) m(a, g[h], e, c);
        return m.filter(f, e)
      };
      m.attr = f.attr, m.selectors.attrMap = {}, f.find = m, f.expr = m.selectors, f.expr[":"] = f.expr.filters, f.unique = m.uniqueSort, f.text = m.getText, f.isXMLDoc = m.isXML, f.contains = m.contains
    }();
  var L = /Until$/,
    M = /^(?:parents|prevUntil|prevAll)/,
    N = /,/,
    O = /^.[^:#\[\.,]*$/,
    P = Array.prototype.slice,
    Q = f.expr.match.POS,
    R = {
      children: !0,
      contents: !0,
      next: !0,
      prev: !0
    };
  f.fn.extend({
    find: function(a) {
      var b = this,
        c, d;
      if (typeof a != "string") return f(a).filter(function() {
        for (c = 0, d = b.length; c < d; c++)
          if (f.contains(b[c], this)) return !0
      });
      var e = this.pushStack("", "find", a),
        g, h, i;
      for (c = 0, d = this.length; c < d; c++) {
        g = e.length, f.find(a, this[c], e);
        if (c > 0)
          for (h = g; h < e.length; h++)
            for (i = 0; i < g; i++)
              if (e[i] === e[h]) {
                e.splice(h--, 1);
                break
              }
      }
      return e
    },
    has: function(a) {
      var b = f(a);
      return this.filter(function() {
        for (var a = 0, c = b.length; a < c; a++)
          if (f.contains(this, b[a])) return !0
      })
    },
    not: function(a) {
      return this.pushStack(T(this, a, !1), "not", a)
    },
    filter: function(a) {
      return this.pushStack(T(this, a, !0), "filter", a)
    },
    is: function(a) {
      return !!a && (typeof a == "string" ? Q.test(a) ? f(a, this.context).index(this[0]) >= 0 : f.filter(a, this).length > 0 : this.filter(a).length > 0)
    },
    closest: function(a, b) {
      var c = [],
        d, e, g = this[0];
      if (f.isArray(a)) {
        var h = 1;
        while (g && g.ownerDocument && g !== b) {
          for (d = 0; d < a.length; d++) f(g).is(a[d]) && c.push({
            selector: a[d],
            elem: g,
            level: h
          });
          g = g.parentNode, h++
        }
        return c
      }
      var i = Q.test(a) || typeof a != "string" ? f(a, b || this.context) : 0;
      for (d = 0, e = this.length; d < e; d++) {
        g = this[d];
        while (g) {
          if (i ? i.index(g) > -1 : f.find.matchesSelector(g, a)) {
            c.push(g);
            break
          }
          g = g.parentNode;
          if (!g || !g.ownerDocument || g === b || g.nodeType === 11) break
        }
      }
      c = c.length > 1 ? f.unique(c) : c;
      return this.pushStack(c, "closest", a)
    },
    index: function(a) {
      if (!a) return this[0] && this[0].parentNode ? this.prevAll().length : -1;
      if (typeof a == "string") return f.inArray(this[0], f(a));
      return f.inArray(a.jquery ? a[0] : a, this)
    },
    add: function(a, b) {
      var c = typeof a == "string" ? f(a, b) : f.makeArray(a && a.nodeType ? [a] : a),
        d = f.merge(this.get(), c);
      return this.pushStack(S(c[0]) || S(d[0]) ? d : f.unique(d))
    },
    andSelf: function() {
      return this.add(this.prevObject)
    }
  }), f.each({
    parent: function(a) {
      var b = a.parentNode;
      return b && b.nodeType !== 11 ? b : null
    },
    parents: function(a) {
      return f.dir(a, "parentNode")
    },
    parentsUntil: function(a, b, c) {
      return f.dir(a, "parentNode", c)
    },
    next: function(a) {
      return f.nth(a, 2, "nextSibling")
    },
    prev: function(a) {
      return f.nth(a, 2, "previousSibling")
    },
    nextAll: function(a) {
      return f.dir(a, "nextSibling")
    },
    prevAll: function(a) {
      return f.dir(a, "previousSibling")
    },
    nextUntil: function(a, b, c) {
      return f.dir(a, "nextSibling", c)
    },
    prevUntil: function(a, b, c) {
      return f.dir(a, "previousSibling", c)
    },
    siblings: function(a) {
      return f.sibling(a.parentNode.firstChild, a)
    },
    children: function(a) {
      return f.sibling(a.firstChild)
    },
    contents: function(a) {
      return f.nodeName(a, "iframe") ? a.contentDocument || a.contentWindow.document : f.makeArray(a.childNodes)
    }
  }, function(a, b) {
    f.fn[a] = function(c, d) {
      var e = f.map(this, b, c);
      L.test(a) || (d = c), d && typeof d == "string" && (e = f.filter(d, e)), e = this.length > 1 && !R[a] ? f.unique(e) : e, (this.length > 1 || N.test(d)) && M.test(a) && (e = e.reverse());
      return this.pushStack(e, a, P.call(arguments).join(","))
    }
  }), f.extend({
    filter: function(a, b, c) {
      c && (a = ":not(" + a + ")");
      return b.length === 1 ? f.find.matchesSelector(b[0], a) ? [b[0]] : [] : f.find.matches(a, b)
    },
    dir: function(a, c, d) {
      var e = [],
        g = a[c];
      while (g && g.nodeType !== 9 && (d === b || g.nodeType !== 1 || !f(g).is(d))) g.nodeType === 1 && e.push(g), g = g[c];
      return e
    },
    nth: function(a, b, c, d) {
      b = b || 1;
      var e = 0;
      for (; a; a = a[c])
        if (a.nodeType === 1 && ++e === b) break;
      return a
    },
    sibling: function(a, b) {
      var c = [];
      for (; a; a = a.nextSibling) a.nodeType === 1 && a !== b && c.push(a);
      return c
    }
  });
  var V = "abbr|article|aside|audio|canvas|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
    W = / jQuery\d+="(?:\d+|null)"/g,
    X = /^\s+/,
    Y = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/ig,
    Z = /<([\w:]+)/,
    $ = /<tbody/i,
    _ = /<|&#?\w+;/,
    ba = /<(?:script|style)/i,
    bb = /<(?:script|object|embed|option|style)/i,
    bc = new RegExp("<(?:" + V + ")", "i"),
    bd = /checked\s*(?:[^=]|=\s*.checked.)/i,
    be = /\/(java|ecma)script/i,
    bf = /^\s*<!(?:\[CDATA\[|\-\-)/,
    bg = {
      option: [1, "<select multiple='multiple'>", "</select>"],
      legend: [1, "<fieldset>", "</fieldset>"],
      thead: [1, "<table>", "</table>"],
      tr: [2, "<table><tbody>", "</tbody></table>"],
      td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
      col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
      area: [1, "<map>", "</map>"],
      _default: [0, "", ""]
    },
    bh = U(c);
  bg.optgroup = bg.option, bg.tbody = bg.tfoot = bg.colgroup = bg.caption = bg.thead, bg.th = bg.td, f.support.htmlSerialize || (bg._default = [1, "div<div>", "</div>"]), f.fn.extend({
    text: function(a) {
      if (f.isFunction(a)) return this.each(function(b) {
        var c = f(this);
        c.text(a.call(this, b, c.text()))
      });
      if (typeof a != "object" && a !== b) return this.empty().append((this[0] && this[0].ownerDocument || c).createTextNode(a));
      return f.text(this)
    },
    wrapAll: function(a) {
      if (f.isFunction(a)) return this.each(function(b) {
        f(this).wrapAll(a.call(this, b))
      });
      if (this[0]) {
        var b = f(a, this[0].ownerDocument).eq(0).clone(!0);
        this[0].parentNode && b.insertBefore(this[0]), b.map(function() {
          var a = this;
          while (a.firstChild && a.firstChild.nodeType === 1) a = a.firstChild;
          return a
        }).append(this)
      }
      return this
    },
    wrapInner: function(a) {
      if (f.isFunction(a)) return this.each(function(b) {
        f(this).wrapInner(a.call(this, b))
      });
      return this.each(function() {
        var b = f(this),
          c = b.contents();
        c.length ? c.wrapAll(a) : b.append(a)
      })
    },
    wrap: function(a) {
      var b = f.isFunction(a);
      return this.each(function(c) {
        f(this).wrapAll(b ? a.call(this, c) : a)
      })
    },
    unwrap: function() {
      return this.parent().each(function() {
        f.nodeName(this, "body") || f(this).replaceWith(this.childNodes)
      }).end()
    },
    append: function() {
      return this.domManip(arguments, !0, function(a) {
        this.nodeType === 1 && this.appendChild(a)
      })
    },
    prepend: function() {
      return this.domManip(arguments, !0, function(a) {
        this.nodeType === 1 && this.insertBefore(a, this.firstChild)
      })
    },
    before: function() {
      if (this[0] && this[0].parentNode) return this.domManip(arguments, !1, function(a) {
        this.parentNode.insertBefore(a, this)
      });
      if (arguments.length) {
        var a = f.clean(arguments);
        a.push.apply(a, this.toArray());
        return this.pushStack(a, "before", arguments)
      }
    },
    after: function() {
      if (this[0] && this[0].parentNode) return this.domManip(arguments, !1, function(a) {
        this.parentNode.insertBefore(a, this.nextSibling)
      });
      if (arguments.length) {
        var a = this.pushStack(this, "after", arguments);
        a.push.apply(a, f.clean(arguments));
        return a
      }
    },
    remove: function(a, b) {
      for (var c = 0, d;
        (d = this[c]) != null; c++)
        if (!a || f.filter(a, [d]).length) !b && d.nodeType === 1 && (f.cleanData(d.getElementsByTagName("*")), f.cleanData([d])), d.parentNode && d.parentNode.removeChild(d);
      return this
    },
    empty: function() {
      for (var a = 0, b;
        (b = this[a]) != null; a++) {
        b.nodeType === 1 && f.cleanData(b.getElementsByTagName("*"));
        while (b.firstChild) b.removeChild(b.firstChild)
      }
      return this
    },
    clone: function(a, b) {
      a = a == null ? !1 : a, b = b == null ? a : b;
      return this.map(function() {
        return f.clone(this, a, b)
      })
    },
    html: function(a) {
      if (a === b) return this[0] && this[0].nodeType === 1 ? this[0].innerHTML.replace(W, "") : null;
      if (typeof a == "string" && !ba.test(a) && (f.support.leadingWhitespace || !X.test(a)) && !bg[(Z.exec(a) || ["", ""])[1].toLowerCase()]) {
        a = a.replace(Y, "<$1></$2>");
        try {
          for (var c = 0, d = this.length; c < d; c++) this[c].nodeType === 1 && (f.cleanData(this[c].getElementsByTagName("*")), this[c].innerHTML = a)
        } catch (e) {
          this.empty().append(a)
        }
      } else f.isFunction(a) ? this.each(function(b) {
        var c = f(this);
        c.html(a.call(this, b, c.html()))
      }) : this.empty().append(a);
      return this
    },
    replaceWith: function(a) {
      if (this[0] && this[0].parentNode) {
        if (f.isFunction(a)) return this.each(function(b) {
          var c = f(this),
            d = c.html();
          c.replaceWith(a.call(this, b, d))
        });
        typeof a != "string" && (a = f(a).detach());
        return this.each(function() {
          var b = this.nextSibling,
            c = this.parentNode;
          f(this).remove(), b ? f(b).before(a) : f(c).append(a)
        })
      }
      return this.length ? this.pushStack(f(f.isFunction(a) ? a() : a), "replaceWith", a) : this
    },
    detach: function(a) {
      return this.remove(a, !0)
    },
    domManip: function(a, c, d) {
      var e, g, h, i, j = a[0],
        k = [];
      if (!f.support.checkClone && arguments.length === 3 && typeof j == "string" && bd.test(j)) return this.each(function() {
        f(this).domManip(a, c, d, !0)
      });
      if (f.isFunction(j)) return this.each(function(e) {
        var g = f(this);
        a[0] = j.call(this, e, c ? g.html() : b), g.domManip(a, c, d)
      });
      if (this[0]) {
        i = j && j.parentNode, f.support.parentNode && i && i.nodeType === 11 && i.childNodes.length === this.length ? e = {
          fragment: i
        } : e = f.buildFragment(a, this, k), h = e.fragment, h.childNodes.length === 1 ? g = h = h.firstChild : g = h.firstChild;
        if (g) {
          c = c && f.nodeName(g, "tr");
          for (var l = 0, m = this.length, n = m - 1; l < m; l++) d.call(c ? bi(this[l], g) : this[l], e.cacheable || m > 1 && l < n ? f.clone(h, !0, !0) : h)
        }
        k.length && f.each(k, bp)
      }
      return this
    }
  }), f.buildFragment = function(a, b, d) {
    var e, g, h, i, j = a[0];
    b && b[0] && (i = b[0].ownerDocument || b[0]), i.createDocumentFragment || (i = c), a.length === 1 && typeof j == "string" && j.length < 512 && i === c && j.charAt(0) === "<" && !bb.test(j) && (f.support.checkClone || !bd.test(j)) && (f.support.html5Clone || !bc.test(j)) && (g = !0, h = f.fragments[j], h && h !== 1 && (e = h)), e || (e = i.createDocumentFragment(), f.clean(a, i, e, d)), g && (f.fragments[j] = h ? e : 1);
    return {
      fragment: e,
      cacheable: g
    }
  }, f.fragments = {}, f.each({
    appendTo: "append",
    prependTo: "prepend",
    insertBefore: "before",
    insertAfter: "after",
    replaceAll: "replaceWith"
  }, function(a, b) {
    f.fn[a] = function(c) {
      var d = [],
        e = f(c),
        g = this.length === 1 && this[0].parentNode;
      if (g && g.nodeType === 11 && g.childNodes.length === 1 && e.length === 1) {
        e[b](this[0]);
        return this
      }
      for (var h = 0, i = e.length; h < i; h++) {
        var j = (h > 0 ? this.clone(!0) : this).get();
        f(e[h])[b](j), d = d.concat(j)
      }
      return this.pushStack(d, a, e.selector)
    }
  }), f.extend({
    clone: function(a, b, c) {
      var d, e, g, h = f.support.html5Clone || !bc.test("<" + a.nodeName) ? a.cloneNode(!0) : bo(a);
      if ((!f.support.noCloneEvent || !f.support.noCloneChecked) && (a.nodeType === 1 || a.nodeType === 11) && !f.isXMLDoc(a)) {
        bk(a, h), d = bl(a), e = bl(h);
        for (g = 0; d[g]; ++g) e[g] && bk(d[g], e[g])
      }
      if (b) {
        bj(a, h);
        if (c) {
          d = bl(a), e = bl(h);
          for (g = 0; d[g]; ++g) bj(d[g], e[g])
        }
      }
      d = e = null;
      return h
    },
    clean: function(a, b, d, e) {
      var g;
      b = b || c, typeof b.createElement == "undefined" && (b = b.ownerDocument || b[0] && b[0].ownerDocument || c);
      var h = [],
        i;
      for (var j = 0, k;
        (k = a[j]) != null; j++) {
        typeof k == "number" && (k += "");
        if (!k) continue;
        if (typeof k == "string")
          if (!_.test(k)) k = b.createTextNode(k);
          else {
            k = k.replace(Y, "<$1></$2>");
            var l = (Z.exec(k) || ["", ""])[1].toLowerCase(),
              m = bg[l] || bg._default,
              n = m[0],
              o = b.createElement("div");
            b === c ? bh.appendChild(o) : U(b).appendChild(o), o.innerHTML = m[1] + k + m[2];
            while (n--) o = o.lastChild;
            if (!f.support.tbody) {
              var p = $.test(k),
                q = l === "table" && !p ? o.firstChild && o.firstChild.childNodes : m[1] === "<table>" && !p ? o.childNodes : [];
              for (i = q.length - 1; i >= 0; --i) f.nodeName(q[i], "tbody") && !q[i].childNodes.length && q[i].parentNode.removeChild(q[i])
            }!f.support.leadingWhitespace && X.test(k) && o.insertBefore(b.createTextNode(X.exec(k)[0]), o.firstChild), k = o.childNodes
          }
        var r;
        if (!f.support.appendChecked)
          if (k[0] && typeof(r = k.length) == "number")
            for (i = 0; i < r; i++) bn(k[i]);
          else bn(k);
        k.nodeType ? h.push(k) : h = f.merge(h, k)
      }
      if (d) {
        g = function(a) {
          return !a.type || be.test(a.type)
        };
        for (j = 0; h[j]; j++)
          if (e && f.nodeName(h[j], "script") && (!h[j].type || h[j].type.toLowerCase() === "text/javascript")) e.push(h[j].parentNode ? h[j].parentNode.removeChild(h[j]) : h[j]);
          else {
            if (h[j].nodeType === 1) {
              var s = f.grep(h[j].getElementsByTagName("script"), g);
              h.splice.apply(h, [j + 1, 0].concat(s))
            }
            d.appendChild(h[j])
          }
      }
      return h
    },
    cleanData: function(a) {
      var b, c, d = f.cache,
        e = f.event.special,
        g = f.support.deleteExpando;
      for (var h = 0, i;
        (i = a[h]) != null; h++) {
        if (i.nodeName && f.noData[i.nodeName.toLowerCase()]) continue;
        c = i[f.expando];
        if (c) {
          b = d[c];
          if (b && b.events) {
            for (var j in b.events) e[j] ? f.event.remove(i, j) : f.removeEvent(i, j, b.handle);
            b.handle && (b.handle.elem = null)
          }
          g ? delete i[f.expando] : i.removeAttribute && i.removeAttribute(f.expando), delete d[c]
        }
      }
    }
  });
  var bq = /alpha\([^)]*\)/i,
    br = /opacity=([^)]*)/,
    bs = /([A-Z]|^ms)/g,
    bt = /^-?\d+(?:px)?$/i,
    bu = /^-?\d/,
    bv = /^([\-+])=([\-+.\de]+)/,
    bw = {
      position: "absolute",
      visibility: "hidden",
      display: "block"
    },
    bx = ["Left", "Right"],
    by = ["Top", "Bottom"],
    bz, bA, bB;
  f.fn.css = function(a, c) {
    if (arguments.length === 2 && c === b) return this;
    return f.access(this, a, c, !0, function(a, c, d) {
      return d !== b ? f.style(a, c, d) : f.css(a, c)
    })
  }, f.extend({
    cssHooks: {
      opacity: {
        get: function(a, b) {
          if (b) {
            var c = bz(a, "opacity", "opacity");
            return c === "" ? "1" : c
          }
          return a.style.opacity
        }
      }
    },
    cssNumber: {
      fillOpacity: !0,
      fontWeight: !0,
      lineHeight: !0,
      opacity: !0,
      orphans: !0,
      widows: !0,
      zIndex: !0,
      zoom: !0
    },
    cssProps: {
      "float": f.support.cssFloat ? "cssFloat" : "styleFloat"
    },
    style: function(a, c, d, e) {
      if (!!a && a.nodeType !== 3 && a.nodeType !== 8 && !!a.style) {
        var g, h, i = f.camelCase(c),
          j = a.style,
          k = f.cssHooks[i];
        c = f.cssProps[i] || i;
        if (d === b) {
          if (k && "get" in k && (g = k.get(a, !1, e)) !== b) return g;
          return j[c]
        }
        h = typeof d, h === "string" && (g = bv.exec(d)) && (d = +(g[1] + 1) * +g[2] + parseFloat(f.css(a, c)), h = "number");
        if (d == null || h === "number" && isNaN(d)) return;
        h === "number" && !f.cssNumber[i] && (d += "px");
        if (!k || !("set" in k) || (d = k.set(a, d)) !== b) try {
          j[c] = d
        } catch (l) {}
      }
    },
    css: function(a, c, d) {
      var e, g;
      c = f.camelCase(c), g = f.cssHooks[c], c = f.cssProps[c] || c, c === "cssFloat" && (c = "float");
      if (g && "get" in g && (e = g.get(a, !0, d)) !== b) return e;
      if (bz) return bz(a, c)
    },
    swap: function(a, b, c) {
      var d = {};
      for (var e in b) d[e] = a.style[e], a.style[e] = b[e];
      c.call(a);
      for (e in b) a.style[e] = d[e]
    }
  }), f.curCSS = f.css, f.each(["height", "width"], function(a, b) {
    f.cssHooks[b] = {
      get: function(a, c, d) {
        var e;
        if (c) {
          if (a.offsetWidth !== 0) return bC(a, b, d);
          f.swap(a, bw, function() {
            e = bC(a, b, d)
          });
          return e
        }
      },
      set: function(a, b) {
        if (!bt.test(b)) return b;
        b = parseFloat(b);
        if (b >= 0) return b + "px"
      }
    }
  }), f.support.opacity || (f.cssHooks.opacity = {
    get: function(a, b) {
      return br.test((b && a.currentStyle ? a.currentStyle.filter : a.style.filter) || "") ? parseFloat(RegExp.$1) / 100 + "" : b ? "1" : ""
    },
    set: function(a, b) {
      var c = a.style,
        d = a.currentStyle,
        e = f.isNumeric(b) ? "alpha(opacity=" + b * 100 + ")" : "",
        g = d && d.filter || c.filter || "";
      c.zoom = 1;
      if (b >= 1 && f.trim(g.replace(bq, "")) === "") {
        c.removeAttribute("filter");
        if (d && !d.filter) return
      }
      c.filter = bq.test(g) ? g.replace(bq, e) : g + " " + e
    }
  }), f(function() {
    f.support.reliableMarginRight || (f.cssHooks.marginRight = {
      get: function(a, b) {
        var c;
        f.swap(a, {
          display: "inline-block"
        }, function() {
          b ? c = bz(a, "margin-right", "marginRight") : c = a.style.marginRight
        });
        return c
      }
    })
  }), c.defaultView && c.defaultView.getComputedStyle && (bA = function(a, b) {
    var c, d, e;
    b = b.replace(bs, "-$1").toLowerCase(), (d = a.ownerDocument.defaultView) && (e = d.getComputedStyle(a, null)) && (c = e.getPropertyValue(b), c === "" && !f.contains(a.ownerDocument.documentElement, a) && (c = f.style(a, b)));
    return c
  }), c.documentElement.currentStyle && (bB = function(a, b) {
    var c, d, e, f = a.currentStyle && a.currentStyle[b],
      g = a.style;
    f === null && g && (e = g[b]) && (f = e), !bt.test(f) && bu.test(f) && (c = g.left, d = a.runtimeStyle && a.runtimeStyle.left, d && (a.runtimeStyle.left = a.currentStyle.left), g.left = b === "fontSize" ? "1em" : f || 0, f = g.pixelLeft + "px", g.left = c, d && (a.runtimeStyle.left = d));
    return f === "" ? "auto" : f
  }), bz = bA || bB, f.expr && f.expr.filters && (f.expr.filters.hidden = function(a) {
    var b = a.offsetWidth,
      c = a.offsetHeight;
    return b === 0 && c === 0 || !f.support.reliableHiddenOffsets && (a.style && a.style.display || f.css(a, "display")) === "none"
  }, f.expr.filters.visible = function(a) {
    return !f.expr.filters.hidden(a)
  });
  var bD = /%20/g,
    bE = /\[\]$/,
    bF = /\r?\n/g,
    bG = /#.*$/,
    bH = /^(.*?):[ \t]*([^\r\n]*)\r?$/mg,
    bI = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,
    bJ = /^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,
    bK = /^(?:GET|HEAD)$/,
    bL = /^\/\//,
    bM = /\?/,
    bN = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
    bO = /^(?:select|textarea)/i,
    bP = /\s+/,
    bQ = /([?&])_=[^&]*/,
    bR = /^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+))?)?/,
    bS = f.fn.load,
    bT = {},
    bU = {},
    bV, bW, bX = ["*/"] + ["*"];
  try {
    bV = e.href
  } catch (bY) {
    bV = c.createElement("a"), bV.href = "", bV = bV.href
  }
  bW = bR.exec(bV.toLowerCase()) || [], f.fn.extend({
    load: function(a, c, d) {
      if (typeof a != "string" && bS) return bS.apply(this, arguments);
      if (!this.length) return this;
      var e = a.indexOf(" ");
      if (e >= 0) {
        var g = a.slice(e, a.length);
        a = a.slice(0, e)
      }
      var h = "GET";
      c && (f.isFunction(c) ? (d = c, c = b) : typeof c == "object" && (c = f.param(c, f.ajaxSettings.traditional), h = "POST"));
      var i = this;
      f.ajax({
        url: a,
        type: h,
        dataType: "html",
        data: c,
        complete: function(a, b, c) {
          c = a.responseText, a.isResolved() && (a.done(function(a) {
            c = a
          }), i.html(g ? f("<div>").append(c.replace(bN, "")).find(g) : c)), d && i.each(d, [c, b, a])
        }
      });
      return this
    },
    serialize: function() {
      return f.param(this.serializeArray())
    },
    serializeArray: function() {
      return this.map(function() {
        return this.elements ? f.makeArray(this.elements) : this
      }).filter(function() {
        return this.name && !this.disabled && (this.checked || bO.test(this.nodeName) || bI.test(this.type))
      }).map(function(a, b) {
        var c = f(this).val();
        return c == null ? null : f.isArray(c) ? f.map(c, function(a, c) {
          return {
            name: b.name,
            value: a.replace(bF, "\r\n")
          }
        }) : {
          name: b.name,
          value: c.replace(bF, "\r\n")
        }
      }).get()
    }
  }), f.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "), function(a, b) {
    f.fn[b] = function(a) {
      return this.on(b, a)
    }
  }), f.each(["get", "post"], function(a, c) {
    f[c] = function(a, d, e, g) {
      f.isFunction(d) && (g = g || e, e = d, d = b);
      return f.ajax({
        type: c,
        url: a,
        data: d,
        success: e,
        dataType: g
      })
    }
  }), f.extend({
    getScript: function(a, c) {
      return f.get(a, b, c, "script")
    },
    getJSON: function(a, b, c) {
      return f.get(a, b, c, "json")
    },
    ajaxSetup: function(a, b) {
      b ? b_(a, f.ajaxSettings) : (b = a, a = f.ajaxSettings), b_(a, b);
      return a
    },
    ajaxSettings: {
      url: bV,
      isLocal: bJ.test(bW[1]),
      global: !0,
      type: "GET",
      contentType: "application/x-www-form-urlencoded",
      processData: !0,
      async: !0,
      accepts: {
        xml: "application/xml, text/xml",
        html: "text/html",
        text: "text/plain",
        json: "application/json, text/javascript",
        "*": bX
      },
      contents: {
        xml: /xml/,
        html: /html/,
        json: /json/
      },
      responseFields: {
        xml: "responseXML",
        text: "responseText"
      },
      converters: {
        "* text": a.String,
        "text html": !0,
        "text json": f.parseJSON,
        "text xml": f.parseXML
      },
      flatOptions: {
        context: !0,
        url: !0
      }
    },
    ajaxPrefilter: bZ(bT),
    ajaxTransport: bZ(bU),
    ajax: function(a, c) {
      function w(a, c, l, m) {
        if (s !== 2) {
          s = 2, q && clearTimeout(q), p = b, n = m || "", v.readyState = a > 0 ? 4 : 0;
          var o, r, u, w = c,
            x = l ? cb(d, v, l) : b,
            y, z;
          if (a >= 200 && a < 300 || a === 304) {
            if (d.ifModified) {
              if (y = v.getResponseHeader("Last-Modified")) f.lastModified[k] = y;
              if (z = v.getResponseHeader("Etag")) f.etag[k] = z
            }
            if (a === 304) w = "notmodified", o = !0;
            else try {
              r = cc(d, x), w = "success", o = !0
            } catch (A) {
              w = "parsererror", u = A
            }
          } else {
            u = w;
            if (!w || a) w = "error", a < 0 && (a = 0)
          }
          v.status = a, v.statusText = "" + (c || w), o ? h.resolveWith(e, [r, w, v]) : h.rejectWith(e, [v, w, u]), v.statusCode(j), j = b, t && g.trigger("ajax" + (o ? "Success" : "Error"), [v, d, o ? r : u]), i.fireWith(e, [v, w]), t && (g.trigger("ajaxComplete", [v, d]), --f.active || f.event.trigger("ajaxStop"))
        }
      }
      typeof a == "object" && (c = a, a = b), c = c || {};
      var d = f.ajaxSetup({}, c),
        e = d.context || d,
        g = e !== d && (e.nodeType || e instanceof f) ? f(e) : f.event,
        h = f.Deferred(),
        i = f.Callbacks("once memory"),
        j = d.statusCode || {},
        k, l = {},
        m = {},
        n, o, p, q, r, s = 0,
        t, u, v = {
          readyState: 0,
          setRequestHeader: function(a, b) {
            if (!s) {
              var c = a.toLowerCase();
              a = m[c] = m[c] || a, l[a] = b
            }
            return this
          },
          getAllResponseHeaders: function() {
            return s === 2 ? n : null
          },
          getResponseHeader: function(a) {
            var c;
            if (s === 2) {
              if (!o) {
                o = {};
                while (c = bH.exec(n)) o[c[1].toLowerCase()] = c[2]
              }
              c = o[a.toLowerCase()]
            }
            return c === b ? null : c
          },
          overrideMimeType: function(a) {
            s || (d.mimeType = a);
            return this
          },
          abort: function(a) {
            a = a || "abort", p && p.abort(a), w(0, a);
            return this
          }
        };
      h.promise(v), v.success = v.done, v.error = v.fail, v.complete = i.add, v.statusCode = function(a) {
        if (a) {
          var b;
          if (s < 2)
            for (b in a) j[b] = [j[b], a[b]];
          else b = a[v.status], v.then(b, b)
        }
        return this
      }, d.url = ((a || d.url) + "").replace(bG, "").replace(bL, bW[1] + "//"), d.dataTypes = f.trim(d.dataType || "*").toLowerCase().split(bP), d.crossDomain == null && (r = bR.exec(d.url.toLowerCase()), d.crossDomain = !(!r || r[1] == bW[1] && r[2] == bW[2] && (r[3] || (r[1] === "http:" ? 80 : 443)) == (bW[3] || (bW[1] === "http:" ? 80 : 443)))), d.data && d.processData && typeof d.data != "string" && (d.data = f.param(d.data, d.traditional)), b$(bT, d, c, v);
      if (s === 2) return !1;
      t = d.global, d.type = d.type.toUpperCase(), d.hasContent = !bK.test(d.type), t && f.active++ === 0 && f.event.trigger("ajaxStart");
      if (!d.hasContent) {
        d.data && (d.url += (bM.test(d.url) ? "&" : "?") + d.data, delete d.data), k = d.url;
        if (d.cache === !1) {
          var x = f.now(),
            y = d.url.replace(bQ, "$1_=" + x);
          d.url = y + (y === d.url ? (bM.test(d.url) ? "&" : "?") + "_=" + x : "")
        }
      }(d.data && d.hasContent && d.contentType !== !1 || c.contentType) && v.setRequestHeader("Content-Type", d.contentType), d.ifModified && (k = k || d.url, f.lastModified[k] && v.setRequestHeader("If-Modified-Since", f.lastModified[k]), f.etag[k] && v.setRequestHeader("If-None-Match", f.etag[k])), v.setRequestHeader("Accept", d.dataTypes[0] && d.accepts[d.dataTypes[0]] ? d.accepts[d.dataTypes[0]] + (d.dataTypes[0] !== "*" ? ", " + bX + "; q=0.01" : "") : d.accepts["*"]);
      for (u in d.headers) v.setRequestHeader(u, d.headers[u]);
      if (d.beforeSend && (d.beforeSend.call(e, v, d) === !1 || s === 2)) {
        v.abort();
        return !1
      }
      for (u in {
          success: 1,
          error: 1,
          complete: 1
        }) v[u](d[u]);
      p = b$(bU, d, c, v);
      if (!p) w(-1, "No Transport");
      else {
        v.readyState = 1, t && g.trigger("ajaxSend", [v, d]), d.async && d.timeout > 0 && (q = setTimeout(function() {
          v.abort("timeout")
        }, d.timeout));
        try {
          s = 1, p.send(l, w)
        } catch (z) {
          if (s < 2) w(-1, z);
          else throw z
        }
      }
      return v
    },
    param: function(a, c) {
      var d = [],
        e = function(a, b) {
          b = f.isFunction(b) ? b() : b, d[d.length] = encodeURIComponent(a) + "=" + encodeURIComponent(b)
        };
      c === b && (c = f.ajaxSettings.traditional);
      if (f.isArray(a) || a.jquery && !f.isPlainObject(a)) f.each(a, function() {
        e(this.name, this.value)
      });
      else
        for (var g in a) ca(g, a[g], c, e);
      return d.join("&").replace(bD, "+")
    }
  }), f.extend({
    active: 0,
    lastModified: {},
    etag: {}
  });
  var cd = f.now(),
    ce = /(\=)\?(&|$)|\?\?/i;
  f.ajaxSetup({
    jsonp: "callback",
    jsonpCallback: function() {
      return f.expando + "_" + cd++
    }
  }), f.ajaxPrefilter("json jsonp", function(b, c, d) {
    var e = b.contentType === "application/x-www-form-urlencoded" && typeof b.data == "string";
    if (b.dataTypes[0] === "jsonp" || b.jsonp !== !1 && (ce.test(b.url) || e && ce.test(b.data))) {
      var g, h = b.jsonpCallback = f.isFunction(b.jsonpCallback) ? b.jsonpCallback() : b.jsonpCallback,
        i = a[h],
        j = b.url,
        k = b.data,
        l = "$1" + h + "$2";
      b.jsonp !== !1 && (j = j.replace(ce, l), b.url === j && (e && (k = k.replace(ce, l)), b.data === k && (j += (/\?/.test(j) ? "&" : "?") + b.jsonp + "=" + h))), b.url = j, b.data = k, a[h] = function(a) {
        g = [a]
      }, d.always(function() {
        a[h] = i, g && f.isFunction(i) && a[h](g[0])
      }), b.converters["script json"] = function() {
        g || f.error(h + " was not called");
        return g[0]
      }, b.dataTypes[0] = "json";
      return "script"
    }
  }), f.ajaxSetup({
    accepts: {
      script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
    },
    contents: {
      script: /javascript|ecmascript/
    },
    converters: {
      "text script": function(a) {
        f.globalEval(a);
        return a
      }
    }
  }), f.ajaxPrefilter("script", function(a) {
    a.cache === b && (a.cache = !1), a.crossDomain && (a.type = "GET", a.global = !1)
  }), f.ajaxTransport("script", function(a) {
    if (a.crossDomain) {
      var d, e = c.head || c.getElementsByTagName("head")[0] || c.documentElement;
      return {
        send: function(f, g) {
          d = c.createElement("script"), d.async = "async", a.scriptCharset && (d.charset = a.scriptCharset), d.src = a.url, d.onload = d.onreadystatechange = function(a, c) {
            if (c || !d.readyState || /loaded|complete/.test(d.readyState)) d.onload = d.onreadystatechange = null, e && d.parentNode && e.removeChild(d), d = b, c || g(200, "success")
          }, e.insertBefore(d, e.firstChild)
        },
        abort: function() {
          d && d.onload(0, 1)
        }
      }
    }
  });
  var cf = a.ActiveXObject ? function() {
      for (var a in ch) ch[a](0, 1)
    } : !1,
    cg = 0,
    ch;
  f.ajaxSettings.xhr = a.ActiveXObject ? function() {
      return !this.isLocal && ci() || cj()
    } : ci,
    function(a) {
      f.extend(f.support, {
        ajax: !!a,
        cors: !!a && "withCredentials" in a
      })
    }(f.ajaxSettings.xhr()), f.support.ajax && f.ajaxTransport(function(c) {
      if (!c.crossDomain || f.support.cors) {
        var d;
        return {
          send: function(e, g) {
            var h = c.xhr(),
              i, j;
            c.username ? h.open(c.type, c.url, c.async, c.username, c.password) : h.open(c.type, c.url, c.async);
            if (c.xhrFields)
              for (j in c.xhrFields) h[j] = c.xhrFields[j];
            c.mimeType && h.overrideMimeType && h.overrideMimeType(c.mimeType), !c.crossDomain && !e["X-Requested-With"] && (e["X-Requested-With"] = "XMLHttpRequest");
            try {
              for (j in e) h.setRequestHeader(j, e[j])
            } catch (k) {}
            h.send(c.hasContent && c.data || null), d = function(a, e) {
              var j, k, l, m, n;
              try {
                if (d && (e || h.readyState === 4)) {
                  d = b, i && (h.onreadystatechange = f.noop, cf && delete ch[i]);
                  if (e) h.readyState !== 4 && h.abort();
                  else {
                    j = h.status, l = h.getAllResponseHeaders(), m = {}, n = h.responseXML, n && n.documentElement && (m.xml = n), m.text = h.responseText;
                    try {
                      k = h.statusText
                    } catch (o) {
                      k = ""
                    }!j && c.isLocal && !c.crossDomain ? j = m.text ? 200 : 404 : j === 1223 && (j = 204)
                  }
                }
              } catch (p) {
                e || g(-1, p)
              }
              m && g(j, k, m, l)
            }, !c.async || h.readyState === 4 ? d() : (i = ++cg, cf && (ch || (ch = {}, f(a).unload(cf)), ch[i] = d), h.onreadystatechange = d)
          },
          abort: function() {
            d && d(0, 1)
          }
        }
      }
    });
  var ck = {},
    cl, cm, cn = /^(?:toggle|show|hide)$/,
    co = /^([+\-]=)?([\d+.\-]+)([a-z%]*)$/i,
    cp, cq = [
      ["height", "marginTop", "marginBottom", "paddingTop", "paddingBottom"],
      ["width", "marginLeft", "marginRight", "paddingLeft", "paddingRight"],
      ["opacity"]
    ],
    cr;
  f.fn.extend({
    show: function(a, b, c) {
      var d, e;
      if (a || a === 0) return this.animate(cu("show", 3), a, b, c);
      for (var g = 0, h = this.length; g < h; g++) d = this[g], d.style && (e = d.style.display, !f._data(d, "olddisplay") && e === "none" && (e = d.style.display = ""), e === "" && f.css(d, "display") === "none" && f._data(d, "olddisplay", cv(d.nodeName)));
      for (g = 0; g < h; g++) {
        d = this[g];
        if (d.style) {
          e = d.style.display;
          if (e === "" || e === "none") d.style.display = f._data(d, "olddisplay") || ""
        }
      }
      return this
    },
    hide: function(a, b, c) {
      if (a || a === 0) return this.animate(cu("hide", 3), a, b, c);
      var d, e, g = 0,
        h = this.length;
      for (; g < h; g++) d = this[g], d.style && (e = f.css(d, "display"), e !== "none" && !f._data(d, "olddisplay") && f._data(d, "olddisplay", e));
      for (g = 0; g < h; g++) this[g].style && (this[g].style.display = "none");
      return this
    },
    _toggle: f.fn.toggle,
    toggle: function(a, b, c) {
      var d = typeof a == "boolean";
      f.isFunction(a) && f.isFunction(b) ? this._toggle.apply(this, arguments) : a == null || d ? this.each(function() {
        var b = d ? a : f(this).is(":hidden");
        f(this)[b ? "show" : "hide"]()
      }) : this.animate(cu("toggle", 3), a, b, c);
      return this
    },
    fadeTo: function(a, b, c, d) {
      return this.filter(":hidden").css("opacity", 0).show().end().animate({
        opacity: b
      }, a, c, d)
    },
    animate: function(a, b, c, d) {
      function g() {
        e.queue === !1 && f._mark(this);
        var b = f.extend({}, e),
          c = this.nodeType === 1,
          d = c && f(this).is(":hidden"),
          g, h, i, j, k, l, m, n, o;
        b.animatedProperties = {};
        for (i in a) {
          g = f.camelCase(i), i !== g && (a[g] = a[i], delete a[i]), h = a[g], f.isArray(h) ? (b.animatedProperties[g] = h[1], h = a[g] = h[0]) : b.animatedProperties[g] = b.specialEasing && b.specialEasing[g] || b.easing || "swing";
          if (h === "hide" && d || h === "show" && !d) return b.complete.call(this);
          c && (g === "height" || g === "width") && (b.overflow = [this.style.overflow, this.style.overflowX, this.style.overflowY], f.css(this, "display") === "inline" && f.css(this, "float") === "none" && (!f.support.inlineBlockNeedsLayout || cv(this.nodeName) === "inline" ? this.style.display = "inline-block" : this.style.zoom = 1))
        }
        b.overflow != null && (this.style.overflow = "hidden");
        for (i in a) j = new f.fx(this, b, i), h = a[i], cn.test(h) ? (o = f._data(this, "toggle" + i) || (h === "toggle" ? d ? "show" : "hide" : 0), o ? (f._data(this, "toggle" + i, o === "show" ? "hide" : "show"), j[o]()) : j[h]()) : (k = co.exec(h), l = j.cur(), k ? (m = parseFloat(k[2]), n = k[3] || (f.cssNumber[i] ? "" : "px"), n !== "px" && (f.style(this, i, (m || 1) + n), l = (m || 1) / j.cur() * l, f.style(this, i, l + n)), k[1] && (m = (k[1] === "-=" ? -1 : 1) * m + l), j.custom(l, m, n)) : j.custom(l, h, ""));
        return !0
      }
      var e = f.speed(b, c, d);
      if (f.isEmptyObject(a)) return this.each(e.complete, [!1]);
      a = f.extend({}, a);
      return e.queue === !1 ? this.each(g) : this.queue(e.queue, g)
    },
    stop: function(a, c, d) {
      typeof a != "string" && (d = c, c = a, a = b), c && a !== !1 && this.queue(a || "fx", []);
      return this.each(function() {
        function h(a, b, c) {
          var e = b[c];
          f.removeData(a, c, !0), e.stop(d)
        }
        var b, c = !1,
          e = f.timers,
          g = f._data(this);
        d || f._unmark(!0, this);
        if (a == null)
          for (b in g) g[b] && g[b].stop && b.indexOf(".run") === b.length - 4 && h(this, g, b);
        else g[b = a + ".run"] && g[b].stop && h(this, g, b);
        for (b = e.length; b--;) e[b].elem === this && (a == null || e[b].queue === a) && (d ? e[b](!0) : e[b].saveState(), c = !0, e.splice(b, 1));
        (!d || !c) && f.dequeue(this, a)
      })
    }
  }), f.each({
    slideDown: cu("show", 1),
    slideUp: cu("hide", 1),
    slideToggle: cu("toggle", 1),
    fadeIn: {
      opacity: "show"
    },
    fadeOut: {
      opacity: "hide"
    },
    fadeToggle: {
      opacity: "toggle"
    }
  }, function(a, b) {
    f.fn[a] = function(a, c, d) {
      return this.animate(b, a, c, d)
    }
  }), f.extend({
    speed: function(a, b, c) {
      var d = a && typeof a == "object" ? f.extend({}, a) : {
        complete: c || !c && b || f.isFunction(a) && a,
        duration: a,
        easing: c && b || b && !f.isFunction(b) && b
      };
      d.duration = f.fx.off ? 0 : typeof d.duration == "number" ? d.duration : d.duration in f.fx.speeds ? f.fx.speeds[d.duration] : f.fx.speeds._default;
      if (d.queue == null || d.queue === !0) d.queue = "fx";
      d.old = d.complete, d.complete = function(a) {
        f.isFunction(d.old) && d.old.call(this), d.queue ? f.dequeue(this, d.queue) : a !== !1 && f._unmark(this)
      };
      return d
    },
    easing: {
      linear: function(a, b, c, d) {
        return c + d * a
      },
      swing: function(a, b, c, d) {
        return (-Math.cos(a * Math.PI) / 2 + .5) * d + c
      }
    },
    timers: [],
    fx: function(a, b, c) {
      this.options = b, this.elem = a, this.prop = c, b.orig = b.orig || {}
    }
  }), f.fx.prototype = {
    update: function() {
      this.options.step && this.options.step.call(this.elem, this.now, this), (f.fx.step[this.prop] || f.fx.step._default)(this)
    },
    cur: function() {
      if (this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null)) return this.elem[this.prop];
      var a, b = f.css(this.elem, this.prop);
      return isNaN(a = parseFloat(b)) ? !b || b === "auto" ? 0 : b : a
    },
    custom: function(a, c, d) {
      function h(a) {
        return e.step(a)
      }
      var e = this,
        g = f.fx;
      this.startTime = cr || cs(), this.end = c, this.now = this.start = a, this.pos = this.state = 0, this.unit = d || this.unit || (f.cssNumber[this.prop] ? "" : "px"), h.queue = this.options.queue, h.elem = this.elem, h.saveState = function() {
        e.options.hide && f._data(e.elem, "fxshow" + e.prop) === b && f._data(e.elem, "fxshow" + e.prop, e.start)
      }, h() && f.timers.push(h) && !cp && (cp = setInterval(g.tick, g.interval))
    },
    show: function() {
      var a = f._data(this.elem, "fxshow" + this.prop);
      this.options.orig[this.prop] = a || f.style(this.elem, this.prop), this.options.show = !0, a !== b ? this.custom(this.cur(), a) : this.custom(this.prop === "width" || this.prop === "height" ? 1 : 0, this.cur()), f(this.elem).show()
    },
    hide: function() {
      this.options.orig[this.prop] = f._data(this.elem, "fxshow" + this.prop) || f.style(this.elem, this.prop), this.options.hide = !0, this.custom(this.cur(), 0)
    },
    step: function(a) {
      var b, c, d, e = cr || cs(),
        g = !0,
        h = this.elem,
        i = this.options;
      if (a || e >= i.duration + this.startTime) {
        this.now = this.end, this.pos = this.state = 1, this.update(), i.animatedProperties[this.prop] = !0;
        for (b in i.animatedProperties) i.animatedProperties[b] !== !0 && (g = !1);
        if (g) {
          i.overflow != null && !f.support.shrinkWrapBlocks && f.each(["", "X", "Y"], function(a, b) {
            h.style["overflow" + b] = i.overflow[a]
          }), i.hide && f(h).hide();
          if (i.hide || i.show)
            for (b in i.animatedProperties) f.style(h, b, i.orig[b]), f.removeData(h, "fxshow" + b, !0), f.removeData(h, "toggle" + b, !0);
          d = i.complete, d && (i.complete = !1, d.call(h))
        }
        return !1
      }
      i.duration == Infinity ? this.now = e : (c = e - this.startTime, this.state = c / i.duration, this.pos = f.easing[i.animatedProperties[this.prop]](this.state, c, 0, 1, i.duration), this.now = this.start + (this.end - this.start) * this.pos), this.update();
      return !0
    }
  }, f.extend(f.fx, {
    tick: function() {
      var a, b = f.timers,
        c = 0;
      for (; c < b.length; c++) a = b[c], !a() && b[c] === a && b.splice(c--, 1);
      b.length || f.fx.stop()
    },
    interval: 13,
    stop: function() {
      clearInterval(cp), cp = null
    },
    speeds: {
      slow: 600,
      fast: 200,
      _default: 400
    },
    step: {
      opacity: function(a) {
        f.style(a.elem, "opacity", a.now)
      },
      _default: function(a) {
        a.elem.style && a.elem.style[a.prop] != null ? a.elem.style[a.prop] = a.now + a.unit : a.elem[a.prop] = a.now
      }
    }
  }), f.each(["width", "height"], function(a, b) {
    f.fx.step[b] = function(a) {
      f.style(a.elem, b, Math.max(0, a.now) + a.unit)
    }
  }), f.expr && f.expr.filters && (f.expr.filters.animated = function(a) {
    return f.grep(f.timers, function(b) {
      return a === b.elem
    }).length
  });
  var cw = /^t(?:able|d|h)$/i,
    cx = /^(?:body|html)$/i;
  "getBoundingClientRect" in c.documentElement ? f.fn.offset = function(a) {
    var b = this[0],
      c;
    if (a) return this.each(function(b) {
      f.offset.setOffset(this, a, b)
    });
    if (!b || !b.ownerDocument) return null;
    if (b === b.ownerDocument.body) return f.offset.bodyOffset(b);
    try {
      c = b.getBoundingClientRect()
    } catch (d) {}
    var e = b.ownerDocument,
      g = e.documentElement;
    if (!c || !f.contains(g, b)) return c ? {
      top: c.top,
      left: c.left
    } : {
      top: 0,
      left: 0
    };
    var h = e.body,
      i = cy(e),
      j = g.clientTop || h.clientTop || 0,
      k = g.clientLeft || h.clientLeft || 0,
      l = i.pageYOffset || f.support.boxModel && g.scrollTop || h.scrollTop,
      m = i.pageXOffset || f.support.boxModel && g.scrollLeft || h.scrollLeft,
      n = c.top + l - j,
      o = c.left + m - k;
    return {
      top: n,
      left: o
    }
  } : f.fn.offset = function(a) {
    var b = this[0];
    if (a) return this.each(function(b) {
      f.offset.setOffset(this, a, b)
    });
    if (!b || !b.ownerDocument) return null;
    if (b === b.ownerDocument.body) return f.offset.bodyOffset(b);
    var c, d = b.offsetParent,
      e = b,
      g = b.ownerDocument,
      h = g.documentElement,
      i = g.body,
      j = g.defaultView,
      k = j ? j.getComputedStyle(b, null) : b.currentStyle,
      l = b.offsetTop,
      m = b.offsetLeft;
    while ((b = b.parentNode) && b !== i && b !== h) {
      if (f.support.fixedPosition && k.position === "fixed") break;
      c = j ? j.getComputedStyle(b, null) : b.currentStyle, l -= b.scrollTop, m -= b.scrollLeft, b === d && (l += b.offsetTop, m += b.offsetLeft, f.support.doesNotAddBorder && (!f.support.doesAddBorderForTableAndCells || !cw.test(b.nodeName)) && (l += parseFloat(c.borderTopWidth) || 0, m += parseFloat(c.borderLeftWidth) || 0), e = d, d = b.offsetParent), f.support.subtractsBorderForOverflowNotVisible && c.overflow !== "visible" && (l += parseFloat(c.borderTopWidth) || 0, m += parseFloat(c.borderLeftWidth) || 0), k = c
    }
    if (k.position === "relative" || k.position === "static") l += i.offsetTop, m += i.offsetLeft;
    f.support.fixedPosition && k.position === "fixed" && (l += Math.max(h.scrollTop, i.scrollTop), m += Math.max(h.scrollLeft, i.scrollLeft));
    return {
      top: l,
      left: m
    }
  }, f.offset = {
    bodyOffset: function(a) {
      var b = a.offsetTop,
        c = a.offsetLeft;
      f.support.doesNotIncludeMarginInBodyOffset && (b += parseFloat(f.css(a, "marginTop")) || 0, c += parseFloat(f.css(a, "marginLeft")) || 0);
      return {
        top: b,
        left: c
      }
    },
    setOffset: function(a, b, c) {
      var d = f.css(a, "position");
      d === "static" && (a.style.position = "relative");
      var e = f(a),
        g = e.offset(),
        h = f.css(a, "top"),
        i = f.css(a, "left"),
        j = (d === "absolute" || d === "fixed") && f.inArray("auto", [h, i]) > -1,
        k = {},
        l = {},
        m, n;
      j ? (l = e.position(), m = l.top, n = l.left) : (m = parseFloat(h) || 0, n = parseFloat(i) || 0), f.isFunction(b) && (b = b.call(a, c, g)), b.top != null && (k.top = b.top - g.top + m), b.left != null && (k.left = b.left - g.left + n), "using" in b ? b.using.call(a, k) : e.css(k)
    }
  }, f.fn.extend({
    position: function() {
      if (!this[0]) return null;
      var a = this[0],
        b = this.offsetParent(),
        c = this.offset(),
        d = cx.test(b[0].nodeName) ? {
          top: 0,
          left: 0
        } : b.offset();
      c.top -= parseFloat(f.css(a, "marginTop")) || 0, c.left -= parseFloat(f.css(a, "marginLeft")) || 0, d.top += parseFloat(f.css(b[0], "borderTopWidth")) || 0, d.left += parseFloat(f.css(b[0], "borderLeftWidth")) || 0;
      return {
        top: c.top - d.top,
        left: c.left - d.left
      }
    },
    offsetParent: function() {
      return this.map(function() {
        var a = this.offsetParent || c.body;
        while (a && !cx.test(a.nodeName) && f.css(a, "position") === "static") a = a.offsetParent;
        return a
      })
    }
  }), f.each(["Left", "Top"], function(a, c) {
    var d = "scroll" + c;
    f.fn[d] = function(c) {
      var e, g;
      if (c === b) {
        e = this[0];
        if (!e) return null;
        g = cy(e);
        return g ? "pageXOffset" in g ? g[a ? "pageYOffset" : "pageXOffset"] : f.support.boxModel && g.document.documentElement[d] || g.document.body[d] : e[d]
      }
      return this.each(function() {
        g = cy(this), g ? g.scrollTo(a ? f(g).scrollLeft() : c, a ? c : f(g).scrollTop()) : this[d] = c
      })
    }
  }), f.each(["Height", "Width"], function(a, c) {
    var d = c.toLowerCase();
    f.fn["inner" + c] = function() {
      var a = this[0];
      return a ? a.style ? parseFloat(f.css(a, d, "padding")) : this[d]() : null
    }, f.fn["outer" + c] = function(a) {
      var b = this[0];
      return b ? b.style ? parseFloat(f.css(b, d, a ? "margin" : "border")) : this[d]() : null
    }, f.fn[d] = function(a) {
      var e = this[0];
      if (!e) return a == null ? null : this;
      if (f.isFunction(a)) return this.each(function(b) {
        var c = f(this);
        c[d](a.call(this, b, c[d]()))
      });
      if (f.isWindow(e)) {
        var g = e.document.documentElement["client" + c],
          h = e.document.body;
        return e.document.compatMode === "CSS1Compat" && g || h && h["client" + c] || g
      }
      if (e.nodeType === 9) return Math.max(e.documentElement["client" + c], e.body["scroll" + c], e.documentElement["scroll" + c], e.body["offset" + c], e.documentElement["offset" + c]);
      if (a === b) {
        var i = f.css(e, d),
          j = parseFloat(i);
        return f.isNumeric(j) ? j : i
      }
      return this.css(d, typeof a == "string" ? a : a + "px")
    }
  }), a.jQuery = a.$ = f, typeof define == "function" && define.amd && define.amd.jQuery && define("jquery", [], function() {
    return f
  })
})(window);

/* ============================================================================
|                                                                             |
|  jquery-ui.min.js                                                           |
|                                                                             |
============================================================================ */

/*
 * jQuery UI Effects 1.8.16
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/
 */

jQuery.effects || function(f, j) {
  function m(c) {
    var a;
    if (c && c.constructor == Array && c.length == 3) return c;
    if (a = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(c)) return [parseInt(a[1], 10), parseInt(a[2], 10), parseInt(a[3], 10)];
    if (a = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(c)) return [parseFloat(a[1]) * 2.55, parseFloat(a[2]) * 2.55, parseFloat(a[3]) * 2.55];
    if (a = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(c)) return [parseInt(a[1],
      16), parseInt(a[2], 16), parseInt(a[3], 16)];
    if (a = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(c)) return [parseInt(a[1] + a[1], 16), parseInt(a[2] + a[2], 16), parseInt(a[3] + a[3], 16)];
    if (/rgba\(0, 0, 0, 0\)/.exec(c)) return n.transparent;
    return n[f.trim(c).toLowerCase()]
  }

  function s(c, a) {
    var b;
    do {
      b = f.curCSS(c, a);
      if (b != "" && b != "transparent" || f.nodeName(c, "body")) break;
      a = "backgroundColor"
    } while (c = c.parentNode);
    return m(b)
  }

  function o() {
    var c = document.defaultView ? document.defaultView.getComputedStyle(this, null) : this.currentStyle,
      a = {},
      b, d;
    if (c && c.length && c[0] && c[c[0]])
      for (var e = c.length; e--;) {
        b = c[e];
        if (typeof c[b] == "string") {
          d = b.replace(/\-(\w)/g, function(g, h) {
            return h.toUpperCase()
          });
          a[d] = c[b]
        }
      } else
        for (b in c)
          if (typeof c[b] === "string") a[b] = c[b];
    return a
  }

  function p(c) {
    var a, b;
    for (a in c) {
      b = c[a];
      if (b == null || f.isFunction(b) || a in t || /scrollbar/.test(a) || !/color/i.test(a) && isNaN(parseFloat(b))) delete c[a]
    }
    return c
  }

  function u(c, a) {
    var b = {
        _: 0
      },
      d;
    for (d in a)
      if (c[d] != a[d]) b[d] = a[d];
    return b
  }

  function k(c, a, b, d) {
    if (typeof c == "object") {
      d =
        a;
      b = null;
      a = c;
      c = a.effect
    }
    if (f.isFunction(a)) {
      d = a;
      b = null;
      a = {}
    }
    if (typeof a == "number" || f.fx.speeds[a]) {
      d = b;
      b = a;
      a = {}
    }
    if (f.isFunction(b)) {
      d = b;
      b = null
    }
    a = a || {};
    b = b || a.duration;
    b = f.fx.off ? 0 : typeof b == "number" ? b : b in f.fx.speeds ? f.fx.speeds[b] : f.fx.speeds._default;
    d = d || a.complete;
    return [c, a, b, d]
  }

  function l(c) {
    if (!c || typeof c === "number" || f.fx.speeds[c]) return true;
    if (typeof c === "string" && !f.effects[c]) return true;
    return false
  }
  f.effects = {};
  f.each(["backgroundColor", "borderBottomColor", "borderLeftColor", "borderRightColor",
    "borderTopColor", "borderColor", "color", "outlineColor"
  ], function(c, a) {
    f.fx.step[a] = function(b) {
      if (!b.colorInit) {
        b.start = s(b.elem, a);
        b.end = m(b.end);
        b.colorInit = true
      }
      b.elem.style[a] = "rgb(" + Math.max(Math.min(parseInt(b.pos * (b.end[0] - b.start[0]) + b.start[0], 10), 255), 0) + "," + Math.max(Math.min(parseInt(b.pos * (b.end[1] - b.start[1]) + b.start[1], 10), 255), 0) + "," + Math.max(Math.min(parseInt(b.pos * (b.end[2] - b.start[2]) + b.start[2], 10), 255), 0) + ")"
    }
  });
  var n = {
      aqua: [0, 255, 255],
      azure: [240, 255, 255],
      beige: [245, 245, 220],
      black: [0,
        0, 0
      ],
      blue: [0, 0, 255],
      brown: [165, 42, 42],
      cyan: [0, 255, 255],
      darkblue: [0, 0, 139],
      darkcyan: [0, 139, 139],
      darkgrey: [169, 169, 169],
      darkgreen: [0, 100, 0],
      darkkhaki: [189, 183, 107],
      darkmagenta: [139, 0, 139],
      darkolivegreen: [85, 107, 47],
      darkorange: [255, 140, 0],
      darkorchid: [153, 50, 204],
      darkred: [139, 0, 0],
      darksalmon: [233, 150, 122],
      darkviolet: [148, 0, 211],
      fuchsia: [255, 0, 255],
      gold: [255, 215, 0],
      green: [0, 128, 0],
      indigo: [75, 0, 130],
      khaki: [240, 230, 140],
      lightblue: [173, 216, 230],
      lightcyan: [224, 255, 255],
      lightgreen: [144, 238, 144],
      lightgrey: [211,
        211, 211
      ],
      lightpink: [255, 182, 193],
      lightyellow: [255, 255, 224],
      lime: [0, 255, 0],
      magenta: [255, 0, 255],
      maroon: [128, 0, 0],
      navy: [0, 0, 128],
      olive: [128, 128, 0],
      orange: [255, 165, 0],
      pink: [255, 192, 203],
      purple: [128, 0, 128],
      violet: [128, 0, 128],
      red: [255, 0, 0],
      silver: [192, 192, 192],
      white: [255, 255, 255],
      yellow: [255, 255, 0],
      transparent: [255, 255, 255]
    },
    q = ["add", "remove", "toggle"],
    t = {
      border: 1,
      borderBottom: 1,
      borderColor: 1,
      borderLeft: 1,
      borderRight: 1,
      borderTop: 1,
      borderWidth: 1,
      margin: 1,
      padding: 1
    };
  f.effects.animateClass = function(c, a, b,
    d) {
    if (f.isFunction(b)) {
      d = b;
      b = null
    }
    return this.queue(function() {
      var e = f(this),
        g = e.attr("style") || " ",
        h = p(o.call(this)),
        r, v = e.attr("class");
      f.each(q, function(w, i) {
        c[i] && e[i + "Class"](c[i])
      });
      r = p(o.call(this));
      e.attr("class", v);
      e.animate(u(h, r), {
        queue: false,
        duration: a,
        easing: b,
        complete: function() {
          f.each(q, function(w, i) {
            c[i] && e[i + "Class"](c[i])
          });
          if (typeof e.attr("style") == "object") {
            e.attr("style").cssText = "";
            e.attr("style").cssText = g
          } else e.attr("style", g);
          d && d.apply(this, arguments);
          f.dequeue(this)
        }
      })
    })
  };
  f.fn.extend({
    _addClass: f.fn.addClass,
    addClass: function(c, a, b, d) {
      return a ? f.effects.animateClass.apply(this, [{
        add: c
      }, a, b, d]) : this._addClass(c)
    },
    _removeClass: f.fn.removeClass,
    removeClass: function(c, a, b, d) {
      return a ? f.effects.animateClass.apply(this, [{
        remove: c
      }, a, b, d]) : this._removeClass(c)
    },
    _toggleClass: f.fn.toggleClass,
    toggleClass: function(c, a, b, d, e) {
      return typeof a == "boolean" || a === j ? b ? f.effects.animateClass.apply(this, [a ? {
        add: c
      } : {
        remove: c
      }, b, d, e]) : this._toggleClass(c, a) : f.effects.animateClass.apply(this, [{
        toggle: c
      }, a, b, d])
    },
    switchClass: function(c, a, b, d, e) {
      return f.effects.animateClass.apply(this, [{
        add: a,
        remove: c
      }, b, d, e])
    }
  });
  f.extend(f.effects, {
    version: "1.8.16",
    save: function(c, a) {
      for (var b = 0; b < a.length; b++) a[b] !== null && c.data("ec.storage." + a[b], c[0].style[a[b]])
    },
    restore: function(c, a) {
      for (var b = 0; b < a.length; b++) a[b] !== null && c.css(a[b], c.data("ec.storage." + a[b]))
    },
    setMode: function(c, a) {
      if (a == "toggle") a = c.is(":hidden") ? "show" : "hide";
      return a
    },
    getBaseline: function(c, a) {
      var b;
      switch (c[0]) {
        case "top":
          b =
            0;
          break;
        case "middle":
          b = 0.5;
          break;
        case "bottom":
          b = 1;
          break;
        default:
          b = c[0] / a.height
      }
      switch (c[1]) {
        case "left":
          c = 0;
          break;
        case "center":
          c = 0.5;
          break;
        case "right":
          c = 1;
          break;
        default:
          c = c[1] / a.width
      }
      return {
        x: c,
        y: b
      }
    },
    createWrapper: function(c) {
      if (c.parent().is(".ui-effects-wrapper")) return c.parent();
      var a = {
          width: c.outerWidth(true),
          height: c.outerHeight(true),
          "float": c.css("float")
        },
        b = f("<div></div>").addClass("ui-effects-wrapper").css({
          fontSize: "100%",
          background: "transparent",
          border: "none",
          margin: 0,
          padding: 0
        }),
        d = document.activeElement;
      c.wrap(b);
      if (c[0] === d || f.contains(c[0], d)) f(d).focus();
      b = c.parent();
      if (c.css("position") == "static") {
        b.css({
          position: "relative"
        });
        c.css({
          position: "relative"
        })
      } else {
        f.extend(a, {
          position: c.css("position"),
          zIndex: c.css("z-index")
        });
        f.each(["top", "left", "bottom", "right"], function(e, g) {
          a[g] = c.css(g);
          if (isNaN(parseInt(a[g], 10))) a[g] = "auto"
        });
        c.css({
          position: "relative",
          top: 0,
          left: 0,
          right: "auto",
          bottom: "auto"
        })
      }
      return b.css(a).show()
    },
    removeWrapper: function(c) {
      var a, b = document.activeElement;
      if (c.parent().is(".ui-effects-wrapper")) {
        a = c.parent().replaceWith(c);
        if (c[0] === b || f.contains(c[0], b)) f(b).focus();
        return a
      }
      return c
    },
    setTransition: function(c, a, b, d) {
      d = d || {};
      f.each(a, function(e, g) {
        unit = c.cssUnit(g);
        if (unit[0] > 0) d[g] = unit[0] * b + unit[1]
      });
      return d
    }
  });
  f.fn.extend({
    effect: function(c) {
      var a = k.apply(this, arguments),
        b = {
          options: a[1],
          duration: a[2],
          callback: a[3]
        };
      a = b.options.mode;
      var d = f.effects[c];
      if (f.fx.off || !d) return a ? this[a](b.duration, b.callback) : this.each(function() {
        b.callback && b.callback.call(this)
      });
      return d.call(this, b)
    },
    _show: f.fn.show,
    show: function(c) {
      if (l(c)) return this._show.apply(this, arguments);
      else {
        var a = k.apply(this, arguments);
        a[1].mode = "show";
        return this.effect.apply(this, a)
      }
    },
    _hide: f.fn.hide,
    hide: function(c) {
      if (l(c)) return this._hide.apply(this, arguments);
      else {
        var a = k.apply(this, arguments);
        a[1].mode = "hide";
        return this.effect.apply(this, a)
      }
    },
    __toggle: f.fn.toggle,
    toggle: function(c) {
      if (l(c) || typeof c === "boolean" || f.isFunction(c)) return this.__toggle.apply(this, arguments);
      else {
        var a = k.apply(this,
          arguments);
        a[1].mode = "toggle";
        return this.effect.apply(this, a)
      }
    },
    cssUnit: function(c) {
      var a = this.css(c),
        b = [];
      f.each(["em", "px", "%", "pt"], function(d, e) {
        if (a.indexOf(e) > 0) b = [parseFloat(a), e]
      });
      return b
    }
  });
  f.easing.jswing = f.easing.swing;
  f.extend(f.easing, {
    def: "easeOutQuad",
    swing: function(c, a, b, d, e) {
      return f.easing[f.easing.def](c, a, b, d, e)
    },
    easeInQuad: function(c, a, b, d, e) {
      return d * (a /= e) * a + b
    },
    easeOutQuad: function(c, a, b, d, e) {
      return -d * (a /= e) * (a - 2) + b
    },
    easeInOutQuad: function(c, a, b, d, e) {
      if ((a /= e / 2) < 1) return d /
        2 * a * a + b;
      return -d / 2 * (--a * (a - 2) - 1) + b
    },
    easeInCubic: function(c, a, b, d, e) {
      return d * (a /= e) * a * a + b
    },
    easeOutCubic: function(c, a, b, d, e) {
      return d * ((a = a / e - 1) * a * a + 1) + b
    },
    easeInOutCubic: function(c, a, b, d, e) {
      if ((a /= e / 2) < 1) return d / 2 * a * a * a + b;
      return d / 2 * ((a -= 2) * a * a + 2) + b
    },
    easeInQuart: function(c, a, b, d, e) {
      return d * (a /= e) * a * a * a + b
    },
    easeOutQuart: function(c, a, b, d, e) {
      return -d * ((a = a / e - 1) * a * a * a - 1) + b
    },
    easeInOutQuart: function(c, a, b, d, e) {
      if ((a /= e / 2) < 1) return d / 2 * a * a * a * a + b;
      return -d / 2 * ((a -= 2) * a * a * a - 2) + b
    },
    easeInQuint: function(c, a, b,
      d, e) {
      return d * (a /= e) * a * a * a * a + b
    },
    easeOutQuint: function(c, a, b, d, e) {
      return d * ((a = a / e - 1) * a * a * a * a + 1) + b
    },
    easeInOutQuint: function(c, a, b, d, e) {
      if ((a /= e / 2) < 1) return d / 2 * a * a * a * a * a + b;
      return d / 2 * ((a -= 2) * a * a * a * a + 2) + b
    },
    easeInSine: function(c, a, b, d, e) {
      return -d * Math.cos(a / e * (Math.PI / 2)) + d + b
    },
    easeOutSine: function(c, a, b, d, e) {
      return d * Math.sin(a / e * (Math.PI / 2)) + b
    },
    easeInOutSine: function(c, a, b, d, e) {
      return -d / 2 * (Math.cos(Math.PI * a / e) - 1) + b
    },
    easeInExpo: function(c, a, b, d, e) {
      return a == 0 ? b : d * Math.pow(2, 10 * (a / e - 1)) + b
    },
    easeOutExpo: function(c,
      a, b, d, e) {
      return a == e ? b + d : d * (-Math.pow(2, -10 * a / e) + 1) + b
    },
    easeInOutExpo: function(c, a, b, d, e) {
      if (a == 0) return b;
      if (a == e) return b + d;
      if ((a /= e / 2) < 1) return d / 2 * Math.pow(2, 10 * (a - 1)) + b;
      return d / 2 * (-Math.pow(2, -10 * --a) + 2) + b
    },
    easeInCirc: function(c, a, b, d, e) {
      return -d * (Math.sqrt(1 - (a /= e) * a) - 1) + b
    },
    easeOutCirc: function(c, a, b, d, e) {
      return d * Math.sqrt(1 - (a = a / e - 1) * a) + b
    },
    easeInOutCirc: function(c, a, b, d, e) {
      if ((a /= e / 2) < 1) return -d / 2 * (Math.sqrt(1 - a * a) - 1) + b;
      return d / 2 * (Math.sqrt(1 - (a -= 2) * a) + 1) + b
    },
    easeInElastic: function(c, a, b,
      d, e) {
      c = 1.70158;
      var g = 0,
        h = d;
      if (a == 0) return b;
      if ((a /= e) == 1) return b + d;
      g || (g = e * 0.3);
      if (h < Math.abs(d)) {
        h = d;
        c = g / 4
      } else c = g / (2 * Math.PI) * Math.asin(d / h);
      return -(h * Math.pow(2, 10 * (a -= 1)) * Math.sin((a * e - c) * 2 * Math.PI / g)) + b
    },
    easeOutElastic: function(c, a, b, d, e) {
      c = 1.70158;
      var g = 0,
        h = d;
      if (a == 0) return b;
      if ((a /= e) == 1) return b + d;
      g || (g = e * 0.3);
      if (h < Math.abs(d)) {
        h = d;
        c = g / 4
      } else c = g / (2 * Math.PI) * Math.asin(d / h);
      return h * Math.pow(2, -10 * a) * Math.sin((a * e - c) * 2 * Math.PI / g) + d + b
    },
    easeInOutElastic: function(c, a, b, d, e) {
      c = 1.70158;
      var g =
        0,
        h = d;
      if (a == 0) return b;
      if ((a /= e / 2) == 2) return b + d;
      g || (g = e * 0.3 * 1.5);
      if (h < Math.abs(d)) {
        h = d;
        c = g / 4
      } else c = g / (2 * Math.PI) * Math.asin(d / h);
      if (a < 1) return -0.5 * h * Math.pow(2, 10 * (a -= 1)) * Math.sin((a * e - c) * 2 * Math.PI / g) + b;
      return h * Math.pow(2, -10 * (a -= 1)) * Math.sin((a * e - c) * 2 * Math.PI / g) * 0.5 + d + b
    },
    easeInBack: function(c, a, b, d, e, g) {
      if (g == j) g = 1.70158;
      return d * (a /= e) * a * ((g + 1) * a - g) + b
    },
    easeOutBack: function(c, a, b, d, e, g) {
      if (g == j) g = 1.70158;
      return d * ((a = a / e - 1) * a * ((g + 1) * a + g) + 1) + b
    },
    easeInOutBack: function(c, a, b, d, e, g) {
      if (g == j) g = 1.70158;
      if ((a /= e / 2) < 1) return d / 2 * a * a * (((g *= 1.525) + 1) * a - g) + b;
      return d / 2 * ((a -= 2) * a * (((g *= 1.525) + 1) * a + g) + 2) + b
    },
    easeInBounce: function(c, a, b, d, e) {
      return d - f.easing.easeOutBounce(c, e - a, 0, d, e) + b
    },
    easeOutBounce: function(c, a, b, d, e) {
      return (a /= e) < 1 / 2.75 ? d * 7.5625 * a * a + b : a < 2 / 2.75 ? d * (7.5625 * (a -= 1.5 / 2.75) * a + 0.75) + b : a < 2.5 / 2.75 ? d * (7.5625 * (a -= 2.25 / 2.75) * a + 0.9375) + b : d * (7.5625 * (a -= 2.625 / 2.75) * a + 0.984375) + b
    },
    easeInOutBounce: function(c, a, b, d, e) {
      if (a < e / 2) return f.easing.easeInBounce(c, a * 2, 0, d, e) * 0.5 + b;
      return f.easing.easeOutBounce(c,
        a * 2 - e, 0, d, e) * 0.5 + d * 0.5 + b
    }
  })
}(jQuery);

/*
 * jQuery UI Effects Transfer 1.8.16
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Transfer
 *
 * Depends:
 *  jquery.effects.core.js
 */

(function(e) {
  e.effects.transfer = function(a) {
    return this.queue(function() {
      var b = e(this),
        c = e(a.options.to),
        d = c.offset();
      c = {
        top: d.top,
        left: d.left,
        height: c.innerHeight(),
        width: c.innerWidth()
      };
      d = b.offset();
      var f = e('<div class="ui-effects-transfer"></div>').appendTo(document.body).addClass(a.options.className).css({
        top: d.top,
        left: d.left,
        height: b.innerHeight(),
        width: b.innerWidth(),
        position: "absolute"
      }).animate(c, a.duration, a.options.easing, function() {
        f.remove();
        a.callback && a.callback.apply(b[0], arguments);
        b.dequeue()
      })
    })
  }
})(jQuery);

/* ============================================================================
|                                                                             |
|  autocomplete.min.js                                                        |
|                                                                             |
============================================================================ */

/**
 *  Ajax Autocomplete for jQuery, version 1.1.3
 *  (c) 2010 Tomas Kirda
 *
 *  Ajax Autocomplete for jQuery is freely distributable under the terms of an MIT-style license.
 *  For details, see the web site: http://www.devbridge.com/projects/autocomplete/jquery/
 *
 *  Last Review: 04/19/2010
 */

(function(d) {
  function l(b, a, c) {
    a = "(" + c.replace(m, "\\$1") + ")";
    return b.replace(new RegExp(a, "gi"), "<strong>$1</strong>")
  }

  function i(b, a) {
    this.el = d(b);
    this.el.attr("autocomplete", "off");
    this.suggestions = [];
    this.data = [];
    this.badQueries = [];
    this.selectedIndex = -1;
    this.currentValue = this.el.val();
    this.intervalId = 0;
    this.cachedResponse = [];
    this.onChangeInterval = null;
    this.ignoreValueChange = false;
    this.serviceUrl = a.serviceUrl;
    this.isLocal = false;
    this.options = {
      autoSubmit: false,
      minChars: 1,
      maxHeight: 300,
      deferRequestBy: 0,
      width: 0,
      highlight: true,
      params: {},
      fnFormatResult: l,
      delimiter: null,
      zIndex: 9999
    };
    this.initialize();
    this.setOptions(a)
  }
  var m = new RegExp("(\\/|\\.|\\*|\\+|\\?|\\||\\(|\\)|\\[|\\]|\\{|\\}|\\\\)", "g");
  d.fn.autocomplete = function(b) {
    return new i(this.get(0) || d("<input />"), b)
  };
  i.prototype = {
    killerFn: null,
    initialize: function() {
      var b, a, c;
      b = this;
      a = Math.floor(Math.random() * 1048576).toString(16);
      c = "Autocomplete_" + a;
      this.killerFn = function(e) {
        if (d(e.target).parents(".autocomplete").size() === 0) {
          b.killSuggestions();
          b.disableKillerFn()
        }
      };
      if (!this.options.width) this.options.width = this.el.width();
      this.mainContainerId = "AutocompleteContainter_" + a;
      d('<div id="' + this.mainContainerId + '" style="position:absolute;z-index:9999;"><div class="autocomplete-w1"><div class="autocomplete" id="' + c + '" style="display:none; width:300px;"></div></div></div>').appendTo("body");
      this.container = d("#" + c);
      this.fixPosition();
      window.opera ? this.el.keypress(function(e) {
        b.onKeyPress(e)
      }) : this.el.keydown(function(e) {
        b.onKeyPress(e)
      });
      this.el.keyup(function(e) {
        b.onKeyUp(e)
      });
      this.el.blur(function() {
        b.enableKillerFn()
      });
      this.el.focus(function() {
        b.fixPosition();
        if (b.el.val() == '') b.onValueChange();
      })
    },
    setOptions: function(b) {
      var a = this.options;
      d.extend(a, b);
      if (a.lookup) {
        this.isLocal = true;
        if (d.isArray(a.lookup)) a.lookup = {
          suggestions: a.lookup,
          data: []
        }
      }
      d("#" + this.mainContainerId).css({
        zIndex: a.zIndex
      });
      this.container.css({
        maxHeight: a.maxHeight + "px",
        width: a.width
      })
    },
    clearCache: function() {
      this.cachedResponse = [];
      this.badQueries = []
    },
    disable: function() {
      this.disabled = true
    },
    enable: function() {
      this.disabled = false
    },
    fixPosition: function() {
      var b = this.el.offset();
      d("#" + this.mainContainerId).css({
        top: b.top + this.el.innerHeight() + "px",
        left: b.left + "px"
      })
    },
    enableKillerFn: function() {
      d(document).bind("click", this.killerFn)
    },
    disableKillerFn: function() {
      d(document).unbind("click", this.killerFn)
    },
    killSuggestions: function() {
      var b = this;
      this.stopKillSuggestions();
      this.intervalId = window.setInterval(function() {
        b.hide();
        b.stopKillSuggestions()
      }, 300)
    },
    stopKillSuggestions: function() {
      window.clearInterval(this.intervalId)
    },
    onKeyPress: function(b) {
      if (!(this.disabled || !this.enabled)) {
        switch (b.keyCode) {
          case 27:
            this.el.val(this.currentValue);
            this.hide();
            break;
          case 9:
          case 13:
            if (this.selectedIndex === -1) {
              this.hide();
              return
            }
            this.select(this.selectedIndex);
            if (b.keyCode === 9) return;
            break;
          case 38:
            this.moveUp();
            break;
          case 40:
            this.moveDown();
            break;
          default:
            return
        }
        b.stopImmediatePropagation();
        b.preventDefault()
      }
    },
    onKeyUp: function(b) {
      if (!this.disabled) {
        switch (b.keyCode) {
          case 38:
          case 40:
            return
        }
        clearInterval(this.onChangeInterval);
        if (this.currentValue !== this.el.val())
          if (this.options.deferRequestBy > 0) {
            var a = this;
            this.onChangeInterval = setInterval(function() {
              a.onValueChange()
            }, this.options.deferRequestBy)
          } else this.onValueChange()
      }
    },
    onValueChange: function() {
      clearInterval(this.onChangeInterval);
      this.currentValue = this.el.val();
      var b = this.getQuery(this.currentValue);
      this.selectedIndex = -1;
      if (this.ignoreValueChange) this.ignoreValueChange = false;
      else b.length < this.options.minChars ? this.hide() : this.getSuggestions(b)
    },
    getQuery: function(b) {
      var a;
      a = this.options.delimiter;
      if (!a) return d.trim(b);
      b = b.split(a);
      return d.trim(b[b.length - 1])
    },
    getSuggestionsLocal: function(b) {
      var a, c, e, g, f;
      c = this.options.lookup;
      e = c.suggestions.length;
      a = {
        suggestions: [],
        data: []
      };
      b = b.toLowerCase();
      for (f = 0; f < e; f++) {
        g = c.suggestions[f];
        if (g.toLowerCase().indexOf(b) === 0) {
          a.suggestions.push(g);
          a.data.push(c.data[f])
        }
      }
      return a
    },
    getSuggestions: function(b) {
      var a, c;
      if ((a = this.isLocal ? this.getSuggestionsLocal(b) : this.cachedResponse[b]) && d.isArray(a.suggestions)) {
        this.suggestions = a.suggestions;
        this.data = a.data;
        this.suggest()
      } else if (!this.isBadQuery(b)) {
        c = this;
        c.options.params.query = b;
        d.get(this.serviceUrl, c.options.params, function(e) {
          c.processResponse(e)
        }, "text")
      }
    },
    isBadQuery: function(b) {
      for (var a = this.badQueries.length; a--;)
        if (b.indexOf(this.badQueries[a]) === 0) return true;
      return false
    },
    hide: function() {
      this.enabled = false;
      this.selectedIndex = -1;
      this.container.hide()
    },
    suggest: function() {
      if (this.suggestions.length === 0) this.hide();
      else {
        var b, a, c, e, g, f, j, k;
        b = this;
        a = this.suggestions.length;
        e = this.options.fnFormatResult;
        g = this.getQuery(this.currentValue);
        j = function(h) {
          return function() {
            b.activate(h)
          }
        };
        k = function(h) {
          return function() {
            b.select(h)
          }
        };
        this.container.hide().empty();
        for (f = 0; f < a; f++) {
          c = this.suggestions[f];
          c = d((b.selectedIndex === f ? '<div class="selected"' : "<div") + ' title="' + c + '">' + e(c, this.data[f], g) + "</div>");
          c.mouseover(j(f));
          c.click(k(f));
          this.container.append(c)
        }
        this.enabled = true;
        this.container.show()
      }
    },
    processResponse: function(b) {
      var a;
      try {
        a = eval("(" + b + ")")
      } catch (c) {
        return
      }
      if (!d.isArray(a.data)) a.data = [];
      if (!this.options.noCache) {
        this.cachedResponse[a.query] = a;
        a.suggestions.length === 0 && this.badQueries.push(a.query)
      }
      if (a.query === this.getQuery(this.currentValue)) {
        this.suggestions = a.suggestions;
        this.data = a.data;
        this.suggest()
      }
    },
    activate: function(b) {
      var a, c;
      a = this.container.children();
      this.selectedIndex !== -1 && a.length > this.selectedIndex && d(a.get(this.selectedIndex)).removeClass();
      this.selectedIndex = b;
      if (this.selectedIndex !== -1 && a.length > this.selectedIndex) {
        c = a.get(this.selectedIndex);
        d(c).addClass("selected")
      }
      return c
    },
    deactivate: function(b, a) {
      b.className = "";
      if (this.selectedIndex === a) this.selectedIndex = -1
    },
    select: function(b) {
      var a;
      if (a = this.suggestions[b]) {
        this.el.val(a);
        if (this.options.autoSubmit) {
          a = this.el.parents("form");
          a.length > 0 && a.get(0).submit()
        }
        this.ignoreValueChange = true;
        this.hide();
        this.onSelect(b)
      }
    },
    moveUp: function() {
      if (this.selectedIndex !== -1)
        if (this.selectedIndex === 0) {
          this.container.children().get(0).className = "";
          this.selectedIndex = -1;
          this.el.val(this.currentValue)
        } else this.adjustScroll(this.selectedIndex - 1)
    },
    moveDown: function() {
      this.selectedIndex !== this.suggestions.length - 1 && this.adjustScroll(this.selectedIndex + 1)
    },
    adjustScroll: function(b) {
      var a, c, e;
      a = this.activate(b).offsetTop;
      c = this.container.scrollTop();
      e = c + this.options.maxHeight - 25;
      if (a < c) this.container.scrollTop(a);
      else a > e && this.container.scrollTop(a - this.options.maxHeight + 25);
      this.el.val(this.getValue(this.suggestions[b]))
    },
    onSelect: function(b) {
      var a, c;
      a = this.options.onSelect;
      c = this.suggestions[b];
      b = this.data[b];
      this.el.val(this.getValue(c));
      d.isFunction(a) && a(c, b, this.el)
    },
    getValue: function(b) {
      var a, c;
      a = this.options.delimiter;
      if (!a) return b;
      c = this.currentValue;
      a = c.split(a);
      if (a.length === 1) return b;
      return c.substr(0, c.length - a[a.length - 1].length) + b
    }
  }
})(jQuery);

/* ============================================================================
|                                                                             |
|  Запуск Autocomplete.                                                       |
|                                                                             |
============================================================================ */

$(function() {
  $('.input_search').autocomplete({
    serviceUrl: thisTemplateRootUrl + 'js/ajax/search.php',
    minChars: 1,
    noCache: false,
    width: 450,
    onSelect: function(value, data) {
      location.replace(data.url);
    },
    fnFormatResult: function(value, data, currentValue) {
      var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
      var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
      return '<a href="' + data.url + '" style="display: block; white-space: normal; overflow: hidden">' +
        (data.image ? '<img align="absmiddle" src="' + data.image + '" width="40" style="float: left; margin-right: 15px" /> ' : '') +
        value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
        (data.sku ? '<br /><span style="color: #aaa; font-size: .75em">Артикул: ' + data.sku + '</span>' : '') +
        '</a>';
    }
  });
});

/* ============================================================================
|                                                                             |
|  jcarousel.min.js                                                           |
|                                                                             |
============================================================================ */

/*! jCarousel - v0.3.0 - 2013-11-22
 * http://sorgalla.com/jcarousel
 * Copyright (c) 2013 Jan Sorgalla; Licensed MIT */

(function(t) {
  "use strict";
  var i = t.jCarousel = {};
  i.version = "0.3.0";
  var s = /^([+\-]=)?(.+)$/;
  i.parseTarget = function(t) {
    var i = !1,
      e = "object" != typeof t ? s.exec(t) : null;
    return e ? (t = parseInt(e[2], 10) || 0, e[1] && (i = !0, "-=" === e[1] && (t *= -1))) : "object" != typeof t && (t = parseInt(t, 10) || 0), {
      target: t,
      relative: i
    }
  }, i.detectCarousel = function(t) {
    for (var i; t.length > 0;) {
      if (i = t.filter("[data-jcarousel]"), i.length > 0) return i;
      if (i = t.find("[data-jcarousel]"), i.length > 0) return i;
      t = t.parent()
    }
    return null
  }, i.base = function(s) {
    return {
      version: i.version,
      _options: {},
      _element: null,
      _carousel: null,
      _init: t.noop,
      _create: t.noop,
      _destroy: t.noop,
      _reload: t.noop,
      create: function() {
        return this._element.attr("data-" + s.toLowerCase(), !0).data(s, this), !1 === this._trigger("create") ? this : (this._create(), this._trigger("createend"), this)
      },
      destroy: function() {
        return !1 === this._trigger("destroy") ? this : (this._destroy(), this._trigger("destroyend"), this._element.removeData(s).removeAttr("data-" + s.toLowerCase()), this)
      },
      reload: function(t) {
        return !1 === this._trigger("reload") ? this : (t && this.options(t), this._reload(), this._trigger("reloadend"), this)
      },
      element: function() {
        return this._element
      },
      options: function(i, s) {
        if (0 === arguments.length) return t.extend({}, this._options);
        if ("string" == typeof i) {
          if (s === void 0) return this._options[i] === void 0 ? null : this._options[i];
          this._options[i] = s
        } else this._options = t.extend({}, this._options, i);
        return this
      },
      carousel: function() {
        return this._carousel || (this._carousel = i.detectCarousel(this.options("carousel") || this._element), this._carousel || t.error('Could not detect carousel for plugin "' + s + '"')), this._carousel
      },
      _trigger: function(i, e, r) {
        var n, o = !1;
        return r = [this].concat(r || []), (e || this._element).each(function() {
          n = t.Event((s + ":" + i).toLowerCase()), t(this).trigger(n, r), n.isDefaultPrevented() && (o = !0)
        }), !o
      }
    }
  }, i.plugin = function(s, e) {
    var r = t[s] = function(i, s) {
      this._element = t(i), this.options(s), this._init(), this.create()
    };
    return r.fn = r.prototype = t.extend({}, i.base(s), e), t.fn[s] = function(i) {
      var e = Array.prototype.slice.call(arguments, 1),
        n = this;
      return "string" == typeof i ? this.each(function() {
        var r = t(this).data(s);
        if (!r) return t.error("Cannot call methods on " + s + " prior to initialization; " + 'attempted to call method "' + i + '"');
        if (!t.isFunction(r[i]) || "_" === i.charAt(0)) return t.error('No such method "' + i + '" for ' + s + " instance");
        var o = r[i].apply(r, e);
        return o !== r && o !== void 0 ? (n = o, !1) : void 0
      }) : this.each(function() {
        var e = t(this).data(s);
        e instanceof r ? e.reload(i) : new r(this, i)
      }), n
    }, r
  }
})(jQuery),
function(t, i) {
  "use strict";
  var s = function(t) {
    return parseFloat(t) || 0
  };
  t.jCarousel.plugin("jcarousel", {
    animating: !1,
    tail: 0,
    inTail: !1,
    resizeTimer: null,
    lt: null,
    vertical: !1,
    rtl: !1,
    circular: !1,
    underflow: !1,
    relative: !1,
    _options: {
      list: function() {
        return this.element().children().eq(0)
      },
      items: function() {
        return this.list().children()
      },
      animation: 400,
      transitions: !1,
      wrap: null,
      vertical: null,
      rtl: null,
      center: !1
    },
    _list: null,
    _items: null,
    _target: null,
    _first: null,
    _last: null,
    _visible: null,
    _fullyvisible: null,
    _init: function() {
      var t = this;
      return this.onWindowResize = function() {
        t.resizeTimer && clearTimeout(t.resizeTimer), t.resizeTimer = setTimeout(function() {
          t.reload()
        }, 100)
      }, this
    },
    _create: function() {
      this._reload(), t(i).on("resize.jcarousel", this.onWindowResize)
    },
    _destroy: function() {
      t(i).off("resize.jcarousel", this.onWindowResize)
    },
    _reload: function() {
      this.vertical = this.options("vertical"), null == this.vertical && (this.vertical = this.list().height() > this.list().width()), this.rtl = this.options("rtl"), null == this.rtl && (this.rtl = function(i) {
        if ("rtl" === ("" + i.attr("dir")).toLowerCase()) return !0;
        var s = !1;
        return i.parents("[dir]").each(function() {
          return /rtl/i.test(t(this).attr("dir")) ? (s = !0, !1) : void 0
        }), s
      }(this._element)), this.lt = this.vertical ? "top" : "left", this.relative = "relative" === this.list().css("position"), this._list = null, this._items = null;
      var i = this._target && this.index(this._target) >= 0 ? this._target : this.closest();
      this.circular = "circular" === this.options("wrap"), this.underflow = !1;
      var s = {
        left: 0,
        top: 0
      };
      return i.length > 0 && (this._prepare(i), this.list().find("[data-jcarousel-clone]").remove(), this._items = null, this.underflow = this._fullyvisible.length >= this.items().length, this.circular = this.circular && !this.underflow, s[this.lt] = this._position(i) + "px"), this.move(s), this
    },
    list: function() {
      if (null === this._list) {
        var i = this.options("list");
        this._list = t.isFunction(i) ? i.call(this) : this._element.find(i)
      }
      return this._list
    },
    items: function() {
      if (null === this._items) {
        var i = this.options("items");
        this._items = (t.isFunction(i) ? i.call(this) : this.list().find(i)).not("[data-jcarousel-clone]")
      }
      return this._items
    },
    index: function(t) {
      return this.items().index(t)
    },
    closest: function() {
      var i, e = this,
        r = this.list().position()[this.lt],
        n = t(),
        o = !1,
        l = this.vertical ? "bottom" : this.rtl && !this.relative ? "left" : "right";
      return this.rtl && this.relative && !this.vertical && (r += this.list().width() - this.clipping()), this.items().each(function() {
        if (n = t(this), o) return !1;
        var a = e.dimension(n);
        if (r += a, r >= 0) {
          if (i = a - s(n.css("margin-" + l)), !(0 >= Math.abs(r) - a + i / 2)) return !1;
          o = !0
        }
      }), n
    },
    target: function() {
      return this._target
    },
    first: function() {
      return this._first
    },
    last: function() {
      return this._last
    },
    visible: function() {
      return this._visible
    },
    fullyvisible: function() {
      return this._fullyvisible
    },
    hasNext: function() {
      if (!1 === this._trigger("hasnext")) return !0;
      var t = this.options("wrap"),
        i = this.items().length - 1;
      return i >= 0 && (t && "first" !== t || i > this.index(this._last) || this.tail && !this.inTail) ? !0 : !1
    },
    hasPrev: function() {
      if (!1 === this._trigger("hasprev")) return !0;
      var t = this.options("wrap");
      return this.items().length > 0 && (t && "last" !== t || this.index(this._first) > 0 || this.tail && this.inTail) ? !0 : !1
    },
    clipping: function() {
      return this._element["inner" + (this.vertical ? "Height" : "Width")]()
    },
    dimension: function(t) {
      return t["outer" + (this.vertical ? "Height" : "Width")](!0)
    },
    scroll: function(i, s, e) {
      if (this.animating) return this;
      if (!1 === this._trigger("scroll", null, [i, s])) return this;
      t.isFunction(s) && (e = s, s = !0);
      var r = t.jCarousel.parseTarget(i);
      if (r.relative) {
        var n, o, l, a, h, u, c, f, d = this.items().length - 1,
          _ = Math.abs(r.target),
          p = this.options("wrap");
        if (r.target > 0) {
          var v = this.index(this._last);
          if (v >= d && this.tail) this.inTail ? "both" === p || "last" === p ? this._scroll(0, s, e) : t.isFunction(e) && e.call(this, !1) : this._scrollTail(s, e);
          else if (n = this.index(this._target), this.underflow && n === d && ("circular" === p || "both" === p || "last" === p) || !this.underflow && v === d && ("both" === p || "last" === p)) this._scroll(0, s, e);
          else if (l = n + _, this.circular && l > d) {
            for (f = d, h = this.items().get(-1); l > f++;) h = this.items().eq(0), u = this._visible.index(h) >= 0, u && h.after(h.clone(!0).attr("data-jcarousel-clone", !0)), this.list().append(h), u || (c = {}, c[this.lt] = this.dimension(h), this.moveBy(c)), this._items = null;
            this._scroll(h, s, e)
          } else this._scroll(Math.min(l, d), s, e)
        } else if (this.inTail) this._scroll(Math.max(this.index(this._first) - _ + 1, 0), s, e);
        else if (o = this.index(this._first), n = this.index(this._target), a = this.underflow ? n : o, l = a - _, 0 >= a && (this.underflow && "circular" === p || "both" === p || "first" === p)) this._scroll(d, s, e);
        else if (this.circular && 0 > l) {
          for (f = l, h = this.items().get(0); 0 > f++;) {
            h = this.items().eq(-1), u = this._visible.index(h) >= 0, u && h.after(h.clone(!0).attr("data-jcarousel-clone", !0)), this.list().prepend(h), this._items = null;
            var g = this.dimension(h);
            c = {}, c[this.lt] = -g, this.moveBy(c)
          }
          this._scroll(h, s, e)
        } else this._scroll(Math.max(l, 0), s, e)
      } else this._scroll(r.target, s, e);
      return this._trigger("scrollend"), this
    },
    moveBy: function(t, i) {
      var e = this.list().position(),
        r = 1,
        n = 0;
      return this.rtl && !this.vertical && (r = -1, this.relative && (n = this.list().width() - this.clipping())), t.left && (t.left = e.left + n + s(t.left) * r + "px"), t.top && (t.top = e.top + n + s(t.top) * r + "px"), this.move(t, i)
    },
    move: function(i, s) {
      s = s || {};
      var e = this.options("transitions"),
        r = !!e,
        n = !!e.transforms,
        o = !!e.transforms3d,
        l = s.duration || 0,
        a = this.list();
      if (!r && l > 0) return a.animate(i, s), void 0;
      var h = s.complete || t.noop,
        u = {};
      if (r) {
        var c = a.css(["transitionDuration", "transitionTimingFunction", "transitionProperty"]),
          f = h;
        h = function() {
          t(this).css(c), f.call(this)
        }, u = {
          transitionDuration: (l > 0 ? l / 1e3 : 0) + "s",
          transitionTimingFunction: e.easing || s.easing,
          transitionProperty: l > 0 ? function() {
            return n || o ? "all" : i.left ? "left" : "top"
          }() : "none",
          transform: "none"
        }
      }
      o ? u.transform = "translate3d(" + (i.left || 0) + "," + (i.top || 0) + ",0)" : n ? u.transform = "translate(" + (i.left || 0) + "," + (i.top || 0) + ")" : t.extend(u, i), r && l > 0 && a.one("transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd", h), a.css(u), 0 >= l && a.each(function() {
        h.call(this)
      })
    },
    _scroll: function(i, s, e) {
      if (this.animating) return t.isFunction(e) && e.call(this, !1), this;
      if ("object" != typeof i ? i = this.items().eq(i) : i.jquery === void 0 && (i = t(i)), 0 === i.length) return t.isFunction(e) && e.call(this, !1), this;
      this.inTail = !1, this._prepare(i);
      var r = this._position(i),
        n = this.list().position()[this.lt];
      if (r === n) return t.isFunction(e) && e.call(this, !1), this;
      var o = {};
      return o[this.lt] = r + "px", this._animate(o, s, e), this
    },
    _scrollTail: function(i, s) {
      if (this.animating || !this.tail) return t.isFunction(s) && s.call(this, !1), this;
      var e = this.list().position()[this.lt];
      this.rtl && this.relative && !this.vertical && (e += this.list().width() - this.clipping()), this.rtl && !this.vertical ? e += this.tail : e -= this.tail, this.inTail = !0;
      var r = {};
      return r[this.lt] = e + "px", this._update({
        target: this._target.next(),
        fullyvisible: this._fullyvisible.slice(1).add(this._visible.last())
      }), this._animate(r, i, s), this
    },
    _animate: function(i, s, e) {
      if (e = e || t.noop, !1 === this._trigger("animate")) return e.call(this, !1), this;
      this.animating = !0;
      var r = this.options("animation"),
        n = t.proxy(function() {
          this.animating = !1;
          var t = this.list().find("[data-jcarousel-clone]");
          t.length > 0 && (t.remove(), this._reload()), this._trigger("animateend"), e.call(this, !0)
        }, this),
        o = "object" == typeof r ? t.extend({}, r) : {
          duration: r
        },
        l = o.complete || t.noop;
      return s === !1 ? o.duration = 0 : t.fx.speeds[o.duration] !== void 0 && (o.duration = t.fx.speeds[o.duration]), o.complete = function() {
        n(), l.call(this)
      }, this.move(i, o), this
    },
    _prepare: function(i) {
      var e, r, n, o, l = this.index(i),
        a = l,
        h = this.dimension(i),
        u = this.clipping(),
        c = this.vertical ? "bottom" : this.rtl ? "left" : "right",
        f = this.options("center"),
        d = {
          target: i,
          first: i,
          last: i,
          visible: i,
          fullyvisible: u >= h ? i : t()
        };
      if (f && (h /= 2, u /= 2), u > h)
        for (;;) {
          if (e = this.items().eq(++a), 0 === e.length) {
            if (!this.circular) break;
            if (e = this.items().eq(0), i.get(0) === e.get(0)) break;
            if (r = this._visible.index(e) >= 0, r && e.after(e.clone(!0).attr("data-jcarousel-clone", !0)), this.list().append(e), !r) {
              var _ = {};
              _[this.lt] = this.dimension(e), this.moveBy(_)
            }
            this._items = null
          }
          if (o = this.dimension(e), 0 === o) break;
          if (h += o, d.last = e, d.visible = d.visible.add(e), n = s(e.css("margin-" + c)), u >= h - n && (d.fullyvisible = d.fullyvisible.add(e)), h >= u) break
        }
      if (!this.circular && !f && u > h)
        for (a = l;;) {
          if (0 > --a) break;
          if (e = this.items().eq(a), 0 === e.length) break;
          if (o = this.dimension(e), 0 === o) break;
          if (h += o, d.first = e, d.visible = d.visible.add(e), n = s(e.css("margin-" + c)), u >= h - n && (d.fullyvisible = d.fullyvisible.add(e)), h >= u) break
        }
      return this._update(d), this.tail = 0, f || "circular" === this.options("wrap") || "custom" === this.options("wrap") || this.index(d.last) !== this.items().length - 1 || (h -= s(d.last.css("margin-" + c)), h > u && (this.tail = h - u)), this
    },
    _position: function(t) {
      var i = this._first,
        s = i.position()[this.lt],
        e = this.options("center"),
        r = e ? this.clipping() / 2 - this.dimension(i) / 2 : 0;
      return this.rtl && !this.vertical ? (s -= this.relative ? this.list().width() - this.dimension(i) : this.clipping() - this.dimension(i), s += r) : s -= r, !e && (this.index(t) > this.index(i) || this.inTail) && this.tail ? (s = this.rtl && !this.vertical ? s - this.tail : s + this.tail, this.inTail = !0) : this.inTail = !1, -s
    },
    _update: function(i) {
      var s, e = this,
        r = {
          target: this._target || t(),
          first: this._first || t(),
          last: this._last || t(),
          visible: this._visible || t(),
          fullyvisible: this._fullyvisible || t()
        },
        n = this.index(i.first || r.first) < this.index(r.first),
        o = function(s) {
          var o = [],
            l = [];
          i[s].each(function() {
            0 > r[s].index(this) && o.push(this)
          }), r[s].each(function() {
            0 > i[s].index(this) && l.push(this)
          }), n ? o = o.reverse() : l = l.reverse(), e._trigger(s + "in", t(o)), e._trigger(s + "out", t(l)), e["_" + s] = i[s]
        };
      for (s in i) o(s);
      return this
    }
  })
}(jQuery, window),
function(t) {
  "use strict";
  t.jcarousel.fn.scrollIntoView = function(i, s, e) {
    var r, n = t.jCarousel.parseTarget(i),
      o = this.index(this._fullyvisible.first()),
      l = this.index(this._fullyvisible.last());
    if (r = n.relative ? 0 > n.target ? Math.max(0, o + n.target) : l + n.target : "object" != typeof n.target ? n.target : this.index(n.target), o > r) return this.scroll(r, s, e);
    if (r >= o && l >= r) return t.isFunction(e) && e.call(this, !1), this;
    for (var a, h = this.items(), u = this.clipping(), c = this.vertical ? "bottom" : this.rtl ? "left" : "right", f = 0;;) {
      if (a = h.eq(r), 0 === a.length) break;
      if (f += this.dimension(a), f >= u) {
        var d = parseFloat(a.css("margin-" + c)) || 0;
        f - d !== u && r++;
        break
      }
      if (0 >= r) break;
      r--
    }
    return this.scroll(r, s, e)
  }
}(jQuery),
function(t) {
  "use strict";
  t.jCarousel.plugin("jcarouselControl", {
    _options: {
      target: "+=1",
      event: "click",
      method: "scroll"
    },
    _active: null,
    _init: function() {
      this.onDestroy = t.proxy(function() {
        this._destroy(), this.carousel().one("jcarousel:createend", t.proxy(this._create, this))
      }, this), this.onReload = t.proxy(this._reload, this), this.onEvent = t.proxy(function(i) {
        i.preventDefault();
        var s = this.options("method");
        t.isFunction(s) ? s.call(this) : this.carousel().jcarousel(this.options("method"), this.options("target"))
      }, this)
    },
    _create: function() {
      this.carousel().one("jcarousel:destroy", this.onDestroy).on("jcarousel:reloadend jcarousel:scrollend", this.onReload), this._element.on(this.options("event") + ".jcarouselcontrol", this.onEvent), this._reload()
    },
    _destroy: function() {
      this._element.off(".jcarouselcontrol", this.onEvent), this.carousel().off("jcarousel:destroy", this.onDestroy).off("jcarousel:reloadend jcarousel:scrollend", this.onReload)
    },
    _reload: function() {
      var i, s = t.jCarousel.parseTarget(this.options("target")),
        e = this.carousel();
      if (s.relative) i = e.jcarousel(s.target > 0 ? "hasNext" : "hasPrev");
      else {
        var r = "object" != typeof s.target ? e.jcarousel("items").eq(s.target) : s.target;
        i = e.jcarousel("target").index(r) >= 0
      }
      return this._active !== i && (this._trigger(i ? "active" : "inactive"), this._active = i), this
    }
  })
}(jQuery),
function(t) {
  "use strict";
  t.jCarousel.plugin("jcarouselPagination", {
    _options: {
      perPage: null,
      item: function(t) {
        return '<a href="#' + t + '">' + t + "</a>"
      },
      event: "click",
      method: "scroll"
    },
    _pages: {},
    _items: {},
    _currentPage: null,
    _init: function() {
      this.onDestroy = t.proxy(function() {
        this._destroy(), this.carousel().one("jcarousel:createend", t.proxy(this._create, this))
      }, this), this.onReload = t.proxy(this._reload, this), this.onScroll = t.proxy(this._update, this)
    },
    _create: function() {
      this.carousel().one("jcarousel:destroy", this.onDestroy).on("jcarousel:reloadend", this.onReload).on("jcarousel:scrollend", this.onScroll), this._reload()
    },
    _destroy: function() {
      this._clear(), this.carousel().off("jcarousel:destroy", this.onDestroy).off("jcarousel:reloadend", this.onReload).off("jcarousel:scrollend", this.onScroll)
    },
    _reload: function() {
      var i = this.options("perPage");
      if (this._pages = {}, this._items = {}, t.isFunction(i) && (i = i.call(this)), null == i) this._pages = this._calculatePages();
      else
        for (var s, e = parseInt(i, 10) || 0, r = this.carousel().jcarousel("items"), n = 1, o = 0;;) {
          if (s = r.eq(o++), 0 === s.length) break;
          this._pages[n] = this._pages[n] ? this._pages[n].add(s) : s, 0 === o % e && n++
        }
      this._clear();
      var l = this,
        a = this.carousel().data("jcarousel"),
        h = this._element,
        u = this.options("item");
      t.each(this._pages, function(i, s) {
        var e = l._items[i] = t(u.call(l, i, s));
        e.on(l.options("event") + ".jcarouselpagination", t.proxy(function() {
          var t = s.eq(0);
          if (a.circular) {
            var e = a.index(a.target()),
              r = a.index(t);
            parseFloat(i) > parseFloat(l._currentPage) ? e > r && (t = "+=" + (a.items().length - e + r)) : r > e && (t = "-=" + (e + (a.items().length - r)))
          }
          a[this.options("method")](t)
        }, l)), h.append(e)
      }), this._update()
    },
    _update: function() {
      var i, s = this.carousel().jcarousel("target");
      t.each(this._pages, function(t, e) {
        return e.each(function() {
          return s.is(this) ? (i = t, !1) : void 0
        }), i ? !1 : void 0
      }), this._currentPage !== i && (this._trigger("inactive", this._items[this._currentPage]), this._trigger("active", this._items[i])), this._currentPage = i
    },
    items: function() {
      return this._items
    },
    _clear: function() {
      this._element.empty(), this._currentPage = null
    },
    _calculatePages: function() {
      for (var t, i = this.carousel().data("jcarousel"), s = i.items(), e = i.clipping(), r = 0, n = 0, o = 1, l = {};;) {
        if (t = s.eq(n++), 0 === t.length) break;
        l[o] = l[o] ? l[o].add(t) : t, r += i.dimension(t), r >= e && (o++, r = 0)
      }
      return l
    }
  })
}(jQuery),
function(t) {
  "use strict";
  t.jCarousel.plugin("jcarouselAutoscroll", {
    _options: {
      target: "+=1",
      interval: 3e3,
      autostart: !0
    },
    _timer: null,
    _init: function() {
      this.onDestroy = t.proxy(function() {
        this._destroy(), this.carousel().one("jcarousel:createend", t.proxy(this._create, this))
      }, this), this.onAnimateEnd = t.proxy(this.start, this)
    },
    _create: function() {
      this.carousel().one("jcarousel:destroy", this.onDestroy), this.options("autostart") && this.start()
    },
    _destroy: function() {
      this.stop(), this.carousel().off("jcarousel:destroy", this.onDestroy)
    },
    start: function() {
      return this.stop(), this.carousel().one("jcarousel:animateend", this.onAnimateEnd), this._timer = setTimeout(t.proxy(function() {
        this.carousel().jcarousel("scroll", this.options("target"))
      }, this), this.options("interval")), this
    },
    stop: function() {
      return this._timer && (this._timer = clearTimeout(this._timer)), this.carousel().off("jcarousel:animateend", this.onAnimateEnd), this
    }
  })
}(jQuery);

/* ============================================================================
|                                                                             |
|  script.js                                                                  |
|                                                                             |
============================================================================ */

$(function() {
  /*disc jcarousel*/
  var jcarousel = $('.popular');

  jcarousel
    .on('jcarousel:reload jcarousel:create', function() {})
    .jcarousel({
      vertical: false,
      scroll: 1,
      auto: 10,
      wrap: 'both',
      visible: 4
    })
    .jcarouselAutoscroll({
      interval: 5000,
      target: '+=1',
      autostart: true
    });

  var jcarousel2 = $('.product-rel .cat');

  jcarousel2
    .on('jcarousel:reload jcarousel:create', function() {})
    .jcarousel({
      vertical: false,
      scroll: 1,
      auto: 10,
      wrap: 'both',
      visible: 3
    })
    .jcarouselAutoscroll({
      interval: 5000,
      target: '+=1',
      autostart: true
    });

  //jcarousel events
  $('.prev-navigation, .prevv')
    .jcarouselControl({
      target: '-=1'
    });

  $('.next-navigation, .nextt')
    .jcarouselControl({
      target: '+=1'
    });

  $('.jcarousel-pagination')
    .on('jcarouselpagination:active', 'a', function() {
      $(this).addClass('active');
    })
    .on('jcarouselpagination:inactive', 'a', function() {
      $(this).removeClass('active');
    })
    .on('click', function(e) {
      e.preventDefault();
    })
    .jcarouselPagination({
      perPage: 1,
      item: function(page) {
        return '<a href="#' + page + '">' + page + '</a>';
      }
    });

  if ($('div.option select[name="variant"]').length > 0) {
    $('select[name="variant"]').change(function() {
      var iPrice = +$('select[name="variant"] option:selected').data('price');
      var iAmount = +$('select[name="variant"] option:selected').data('amount');

      $('div.product-right div.price b').html(iPrice);

      $('select[name="amount"] option').hide();
      $('select[name="amount"] option:lt(' + iAmount + ')').show();
    });
  }

  if ($('div.options').length) {
    $('div.options a').toggle(function(e) {
      var btn = $(this);
      var line = btn.closest('li');
      var amount = line.find('div.amount');

      btn.addClass('selected');
      amount.fadeIn();

      return false;
    }, function(e) {
      var btn = $(this);
      var line = btn.closest('li');
      var amount = line.find('div.amount');

      btn.removeClass('selected');
      amount.fadeOut();
    });

    $('div.spinner i').click(function() {
      var btn = $(this);
      var input = $(this).closest('div.amount').find('input[type="text"]');
      var max = input.data('max');
      var amount = +input.val();

      if ($(this).hasClass('spinner-up')) {
        amount = ++amount;
        if (amount > max)
          amount = --amount;
        input.val(amount);
      } else {
        amount = --amount;
        if (amount == 0)
          amount = 1;
        input.val(amount);
      }
    });

    $('#addtocard').click(function() {
      var button = $(this);
      var form = $('form[name="variants"]');
      var lines = form.find('li:not(.first)');
      if (form.find('a.selected').length) {
        lines.each(function() {
          var t = $(this),
            link = t.find('a'),
            variant = link.data('id'),
            amount = +t.find('input').val();
          if (link.hasClass('selected')) {
            $.ajax({
              url: 'cart/add/' + variant,
              type: 'POST',
              data: {
                amount: amount,
                ajax: 1
              },
              error: function(xhr, status, thrown) {
                alert('Ошибка ajax-связи с сайтом!\n\nОписание: ' + thrown + '\n\nТип ошибки: ' + status);
              },
              success: function(data) {
                $('#cart_informer').html(data);
                if (button.attr('data-result-text')) button.val(button.attr('data-result-text'));
                link.click();
              }
            });
          }
        });
      } else form.find('div.error').fadeIn();
      return false;
    });
  }
});

jQuery(document).ready(function() {
  if (jQuery('div.option select[name="variant"]').length > 0) {
    jQuery('select[name="amount"] option').hide();
    jQuery('select[name="amount"] option:lt(' + jQuery('select[name="variant"] option:selected').data('amount') + ')').show();
  }
});

/* ============================================================================
|                                                                             |
|  Обработка кнопки Наверх страницы.                                          |
|                                                                             |
============================================================================ */

jQuery(document).ready(function() {
  jQuery('#back-top').hide().click(function() {
    jQuery('body, html').animate({
      scrollTop: 0
    }, 800);
    return false;
  });
  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 100) jQuery('#back-top').fadeIn();
    else jQuery('#back-top').fadeOut();
  });
});

/* ============================================================================
|                                                                             |
|  Скролл к объекту на странице.                                              |
|                                                                             |
============================================================================ */

function scrollToObject(selector, time) {
  try {
    var top = jQuery(selector).offset().top;
    jQuery('body, html').animate({
      scrollTop: top
    }, time);
  } catch (e) {}
};

/* ============================================================================
|                                                                             |
|  Показ SEO фрагмента.                                                       |
|                                                                             |
============================================================================ */

function toggleSeoDetails(selector, time) {
  try {
    jQuery(selector).toggle(time, function() {
      scrollToObject(selector, 0);
    });
  } catch (e) {}
  return false;
};

/* ============================================================================
|                                                                             |
|  Обработчик смены валюты.                                                   |
|                                                                             |
============================================================================ */

function changeCurrency(id) {
  try {
    var form = document.getElementById('currencyForm');
    if (typeof form != 'undefined') {
      var input = document.getElementById('currencyFormInput');
      if (typeof input != 'undefined') {
        input.value = id;
        form.submit();
      }
    }
  } catch (e) {}
};

/* ============================================================================
|                                                                             |
|  Обработчик клика кнопки "Оформить заказ".                                  |
|                                                                             |
============================================================================ */

function clickCartSubmitKey(key) {
  var form = $(key).closest('form');
  $(form).find('input[name="submit_order"]').val(1);
  $(form).submit();
  return false;
};

/* ============================================================================
|                                                                             |
|  Обработчик клика закладок на странице товара.                              |
|                                                                             |
============================================================================ */

function switchDescriptionTab(anchor, classname) {
  try {
    jQuery(anchor).closest('.desc-menu').find('a').removeClass('active');
    jQuery(anchor).addClass('active');
    var box = jQuery(anchor).closest('.product-desc').find('.desc-data');
    jQuery(box).children('div').hide();
    if (classname == 'desc-info') {
      jQuery(box).find('.' + classname).parent('div').show();
    } else {
      jQuery(box).find('.' + classname).show();
    }
  } catch (e) {}
}

/* ============================================================================
|                                                                             |
|  Обработчик клика ФОТО / ВИДЕО на странице товара.                          |
|                                                                             |
============================================================================ */

var showMP4video_activeId = false;

function showMP4video(anchor) {
  try {
    var id = $(anchor).attr('data-id');
    if (id !== showMP4video_activeId) {
      var url = $(anchor).attr('href');
      if (typeof url == 'string' && url != '') {
        var box = $('#image-video > #wrap');
        var h = $(box).height();
        $(box).hide();
        var text = '<video autoplay width="350">' + /* controls loop */
          '<source src="' + url + '" type="video/mp4" />' +
          /* '<object type="application/x-shockwave-flash" width="350">' +
                 '<param name="movie" value="' + thisTemplateRootUrl + 'js/flowplayer.swf" />' +
                 '<param name="flashvars" value="config={ \'clip\': \'' + url + '\' }" />' +
                 '<p>Ваш брайзер не поддерживает просмотр видео в формате MP4. Можете скачать его в виде <a href="' + url + '">файла</a>.</p>' +
             '</object>' + */
          '</video>';
        $('#image-video > .video-box').html(text).css({
          display: 'block',
          opacity: 0,
          height: 0,
          'min-height': h + 'px'
        }).animate({
          height: h + 'px',
          opacity: .5
        }, 1000, function() {
          $(this).css({
            opacity: 1,
            'min-height': 0,
            height: 'auto'
          });
        });
        showMP4video_activeId = id;
      }
    }
  } catch (e) {}
  return false;
}

function showZOOMimage(anchor) {
  try {
    if (showMP4video_activeId !== false) {
      $('#image-video > .video-box').html('').hide();
      $('#image-video > #wrap').show();
      showMP4video_activeId = false;
    }
  } catch (e) {}
  return false;
}

/* ============================================================================
|                                                                             |
|  selectbox.min.js                                                           |
|                                                                             |
============================================================================ */

/* jQuery SelectBox Styler v1.0.1 | (c) Dimox | http://dimox.name/styling-select-boxes-using-jquery-css/ */

(function($) {
  $.fn.selectbox = function() {
    $(this).each(function() {
      var select = $(this);
      if (select.prev('span.selectbox').length < 1) {
        function doSelect() {
          var option = select.find('option');
          var optionSelected = option.filter(':selected');
          var optionText = option.filter(':first').text();
          if (optionSelected.length) optionText = optionSelected.text();
          var ddlist = '';
          for (i = 0; i < option.length; i++) {
            var selected = '';
            var disabled = ' class="disabled"';
            if (option.eq(i).is(':selected')) selected = ' class="selected sel"';
            if (option.eq(i).is(':disabled')) selected = disabled;
            ddlist += '<li' + selected + '>' + option.eq(i).text() + '</li>';
          }
          var selectbox = $('<span class="selectbox" style="display:inline-block;position:relative">' + '<div class="select" style="float:left;position:relative;z-index:10000"><div class="text">' + optionText + '</div>' + '<b class="trigger"><i class="arrow"></i></b>' + '</div>' + '<div class="dropdown" style="position:absolute;z-index:9999;overflow:auto;overflow-x:hidden;list-style:none"><div class="top_span"></div>' + '<ul>' + ddlist + '</ul>' + '</div>' + '</span>');
          select.before(selectbox).css({
            position: 'absolute',
            top: -9999
          });
          var divSelect = selectbox.find('div.select');
          var divText = selectbox.find('div.text');
          var dropdown = selectbox.find('div.dropdown');
          var li = dropdown.find('li');
          var selectHeight = selectbox.outerHeight();
          if (dropdown.css('left') == 'auto') dropdown.css({
            left: 0
          });
          if (dropdown.css('top') == 'auto') dropdown.css({
            top: selectHeight
          });
          var liHeight = li.outerHeight();
          var position = dropdown.css('top');
          dropdown.hide();
          divSelect.click(function() {
            var topOffset = selectbox.offset().top;
            var bottomOffset = $(window).height() - selectHeight - (topOffset - $(window).scrollTop());
            if (bottomOffset < 0 || bottomOffset < liHeight * 6) {
              dropdown.height('auto').css({
                top: 'auto',
                bottom: position
              });
              if (dropdown.outerHeight() > topOffset - $(window).scrollTop() - 20) {
                dropdown.height(Math.floor((topOffset - $(window).scrollTop() - 20) / liHeight) * liHeight);
              }
            } else if (bottomOffset > liHeight * 6) {
              dropdown.height('auto').css({
                bottom: 'auto',
                top: position
              });
              if (dropdown.outerHeight() > bottomOffset - 20) {
                dropdown.height(Math.floor((bottomOffset - 20) / liHeight) * liHeight);
              }
            }
            $('span.selectbox').css({
              zIndex: 1
            }).removeClass('focused');
            selectbox.css({
              zIndex: 2
            });
            if (dropdown.is(':hidden')) {
              $('div.dropdown:visible').hide();
              dropdown.show();
            } else {
              dropdown.hide();
            }
            return false;
          });
          li.hover(function() {
            $(this).siblings().removeClass('selected');
          });
          var selectedText = li.filter('.selected').text();
          li.filter(':not(.disabled)').click(function() {
            var liText = $(this).text();
            if (selectedText != liText) {
              $(this).addClass('selected sel').siblings().removeClass('selected sel');
              option.removeAttr('selected').eq($(this).index()).attr('selected', true);
              selectedText = liText;
              divText.text(liText);
              select.change();
            }
            dropdown.hide();
          });
          dropdown.mouseout(function() {
            dropdown.find('li.sel').addClass('selected');
          });
          select.focus(function() {
            $('span.selectbox').removeClass('focused');
            selectbox.addClass('focused');
          }).keyup(function() {
            divText.text(option.filter(':selected').text());
            li.removeClass('selected sel').eq(option.filter(':selected').index()).addClass('selected sel');
          });
          $(document).on('click', function(e) {
            if (!$(e.target).parents().hasClass('selectbox')) {
              dropdown.hide().find('li.sel').addClass('selected');
              selectbox.removeClass('focused');
            }
          });
        }
        doSelect();
        select.on('refresh', function() {
          select.prev().remove();
          doSelect();
        })
      }
    });
  }
})(jQuery);

/* ============================================================================
|                                                                             |
|  mousewheel.js                                                              |
|                                                                             |
============================================================================ */

/* Copyright (c) 2006 Brandon Aaron (brandon.aaron@gmail.com || http://brandonaaron.net)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 *
 * jQueryLastChangedDate: 2007-12-20 09:02:08 -0600 (Thu, 20 Dec 2007) jQuery
 * jQueryRev: 4265 jQuery
 *
 * Version: 3.0
 *
 * Requires: jQuery 1.2.2+
 */

(function(jQuery) {
  jQuery.event.special.mousewheel = {
    setup: function() {
      var handler = jQuery.event.special.mousewheel.handler;

      // Fix pageX, pageY, clientX and clientY for mozilla
      if (jQuery.browser.mozilla)
        jQuery(this).bind('mousemove.mousewheel', function(event) {
          jQuery.data(this, 'mwcursorposdata', {
            pageX: event.pageX,
            pageY: event.pageY,
            clientX: event.clientX,
            clientY: event.clientY
          });
        });

      if (this.addEventListener)
        this.addEventListener((jQuery.browser.mozilla ? 'DOMMouseScroll' : 'mousewheel'), handler, false);
      else
        this.onmousewheel = handler;
    },

    teardown: function() {
      var handler = jQuery.event.special.mousewheel.handler;

      jQuery(this).unbind('mousemove.mousewheel');

      if (this.removeEventListener)
        this.removeEventListener((jQuery.browser.mozilla ? 'DOMMouseScroll' : 'mousewheel'), handler, false);
      else
        this.onmousewheel = function() {};

      jQuery.removeData(this, 'mwcursorposdata');
    },

    handler: function(event) {
      var args = Array.prototype.slice.call(arguments, 1);

      event = jQuery.event.fix(event || window.event);
      // Get correct pageX, pageY, clientX and clientY for mozilla
      jQuery.extend(event, jQuery.data(this, 'mwcursorposdata') || {});
      var delta = 0,
        returnValue = true;

      if (event.wheelDelta) delta = event.wheelDelta / 120;
      if (event.detail) delta = -event.detail / 3;
      /*  if ( jQuery.browser.opera  ) delta = -event.wheelDelta; */

      event.data = event.data || {};
      event.type = "mousewheel";

      /* Add delta to the front of the arguments */
      args.unshift(delta);
      /* Add event to the front of the arguments */
      args.unshift(event);

      return jQuery.event.handle.apply(this, args);
    }
  };

  jQuery.fn.extend({
    mousewheel: function(fn) {
      return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
    },

    unmousewheel: function(fn) {
      return this.unbind("mousewheel", fn);
    }
  });
})(jQuery);

/* ============================================================================
|                                                                             |
|  jscroll.js                                                                 |
|                                                                             |
============================================================================ */

/* Copyright (c) 2009 Kelvin Luck (kelvin AT kelvinluck DOT com || http://www.kelvinluck.com)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * See http://kelvinluck.com/assets/jquery/jScrollPane/
 * $Id: jScrollPane.js 86 2009-08-30 21:45:11Z kelvin.luck@gmail.com $
 */

/**
 * Replace the vertical scroll bars on any matched elements with a fancy
 * styleable (via CSS) version. With JS disabled the elements will
 * gracefully degrade to the browsers own implementation of overflow:auto.
 * If the mousewheel plugin has been included on the page then the scrollable areas will also
 * respond to the mouse wheel.
 *
 * @example jQuery(".scroll-pane").jScrollPane();
 *
 * @name jScrollPane
 * @type jQuery
 * @param Object    settings    hash with options, described below.
 *                              scrollbarWidth  -   The width of the generated scrollbar in pixels
 *                              scrollbarMargin -   The amount of space to leave on the side of the scrollbar in pixels
 *                              wheelSpeed      -   The speed the pane will scroll in response to the mouse wheel in pixels
 *                              showArrows      -   Whether to display arrows for the user to scroll with
 *                              arrowSize       -   The height of the arrow buttons if showArrows=true
 *                              animateTo       -   Whether to animate when calling scrollTo and scrollBy
 *                              dragMinHeight   -   The minimum height to allow the drag bar to be
 *                              dragMaxHeight   -   The maximum height to allow the drag bar to be
 *                              animateInterval -   The interval in milliseconds to update an animating scrollPane (default 100)
 *                              animateStep     -   The amount to divide the remaining scroll distance by when animating (default 3)
 *                              maintainPosition-   Whether you want the contents of the scroll pane to maintain it's position when you re-initialise it - so it doesn't scroll as you add more content (default true)
 *                              tabIndex        -   The tabindex for this jScrollPane to control when it is tabbed to when navigating via keyboard (default 0)
 *                              enableKeyboardNavigation - Whether to allow keyboard scrolling of this jScrollPane when it is focused (default true)
 *                              animateToInternalLinks - Whether the move to an internal link (e.g. when it's focused by tabbing or by a hash change in the URL) should be animated or instant (default false)
 *                              scrollbarOnLeft -   Display the scrollbar on the left side?  (needs stylesheet changes, see examples.html)
 *                              reinitialiseOnImageLoad - Whether the jScrollPane should automatically re-initialise itself when any contained images are loaded (default false)
 *                              topCapHeight    -   The height of the "cap" area between the top of the jScrollPane and the top of the track/ buttons
 *                              bottomCapHeight -   The height of the "cap" area between the bottom of the jScrollPane and the bottom of the track/ buttons
 * @return jQuery
 * @cat Plugins/jScrollPane
 * @author Kelvin Luck (kelvin AT kelvinluck DOT com || http://www.kelvinluck.com)
 */

(function($) {
  $.jScrollPane = {
    active: []
  };

  $.fn.jScrollPane = function(settings) {
    settings = $.extend({}, $.fn.jScrollPane.defaults, settings);

    var rf = function() {
      return false;
    };

    return this.each(function() {
      var $this = $(this);
      var paneEle = this;
      var currentScrollPosition = 0;
      var paneWidth;
      var paneHeight;
      var trackHeight;
      var trackOffset = settings.topCapHeight;

      if ($(this).parent().is('.jScrollPaneContainer')) {
        currentScrollPosition = settings.maintainPosition ? $this.position().top : 0;
        var $c = $(this).parent();
        paneWidth = $c.innerWidth();
        paneHeight = $c.outerHeight();
        $('>.jScrollPaneTrack, >.jScrollArrowUp, >.jScrollArrowDown, >.jScollCap', $c).remove();
        $this.css({
          'top': 0
        });
      } else {
        $this.data('originalStyleTag', $this.attr('style'));
        // Switch the element's overflow to hidden to ensure we get the size of the element without the scrollbars [http://plugins.jquery.com/node/1208]
        $this.css('overflow', 'hidden');
        this.originalPadding = $this.css('paddingTop') + ' ' + $this.css('paddingRight') + ' ' + $this.css('paddingBottom') + ' ' + $this.css('paddingLeft');
        this.originalSidePaddingTotal = (parseInt($this.css('paddingLeft')) || 0) + (parseInt($this.css('paddingRight')) || 0);
        paneWidth = $this.innerWidth();
        paneHeight = $this.innerHeight();
        var $container = $('<div></div>')
          .attr({
            'class': 'jScrollPaneContainer'
          })
          .css({
            'height': paneHeight + 'px',
            'width': paneWidth + 'px'
          });
        if (settings.enableKeyboardNavigation) {
          $container.attr(
            'tabindex',
            settings.tabIndex
          );
        }
        $this.wrap($container);
        // deal with text size changes (if the jquery.em plugin is included)
        // and re-initialise the scrollPane so the track maintains the
        // correct size
        $(document).bind(
          'emchange',
          function(e, cur, prev) {
            $this.jScrollPane(settings);
          }
        );

      }
      trackHeight = paneHeight;

      if (settings.reinitialiseOnImageLoad) {
        // code inspired by jquery.onImagesLoad: http://plugins.jquery.com/project/onImagesLoad
        // except we re-initialise the scroll pane when each image loads so that the scroll pane is always up to size...
        // TODO: Do I even need to store it in $.data? Is a local variable here the same since I don't pass the reinitialiseOnImageLoad when I re-initialise?
        var $imagesToLoad = $.data(paneEle, 'jScrollPaneImagesToLoad') || $('img', $this);
        var loadedImages = [];

        if ($imagesToLoad.length) {
          $imagesToLoad.each(function(i, val) {
            $(this).bind('load readystatechange', function() {
              if ($.inArray(i, loadedImages) == -1) { //don't double count images
                loadedImages.push(val); //keep a record of images we've seen
                $imagesToLoad = $.grep($imagesToLoad, function(n, i) {
                  return n != val;
                });
                $.data(paneEle, 'jScrollPaneImagesToLoad', $imagesToLoad);
                var s2 = $.extend(settings, {
                  reinitialiseOnImageLoad: false
                });
                $this.jScrollPane(s2); // re-initialise
              }
            }).each(function(i, val) {
              if (this.complete || this.complete === undefined) {
                //needed for potential cached images
                this.src = this.src;
              }
            });
          });
        };
      }

      var p = this.originalSidePaddingTotal;
      var realPaneWidth = paneWidth - settings.scrollbarWidth - settings.scrollbarMargin - p;

      var cssToApply = {
        'height': 'auto',
        'width': realPaneWidth + 'px'
      }

      if (settings.scrollbarOnLeft) {
        cssToApply.paddingLeft = settings.scrollbarMargin + settings.scrollbarWidth + 'px';
      } else {
        cssToApply.paddingRight = settings.scrollbarMargin + 'px';
      }

      $this.css(cssToApply);

      var contentHeight = $this.outerHeight();
      var percentInView = paneHeight / contentHeight;

      if (percentInView < .99) {
        var $container = $this.parent();
        $container.append(
          $('<div></div>').addClass('jScrollCap jScrollCapTop').css({
            height: settings.topCapHeight
          }),
          $('<div></div>').attr({
            'class': 'jScrollPaneTrack'
          }).css({
            'width': settings.scrollbarWidth + 'px'
          }).append(
            $('<div></div>').attr({
              'class': 'jScrollPaneDrag'
            }).css({
              'width': settings.scrollbarWidth + 'px'
            }).append(
              $('<div></div>').attr({
                'class': 'jScrollPaneDragTop'
              }).css({
                'width': settings.scrollbarWidth + 'px'
              }),
              $('<div></div>').attr({
                'class': 'jScrollPaneDragBottom'
              }).css({
                'width': settings.scrollbarWidth + 'px'
              })
            )
          ),
          $('<div></div>').addClass('jScrollCap jScrollCapBottom').css({
            height: settings.bottomCapHeight
          })
        );

        var $track = $('>.jScrollPaneTrack', $container);
        var $drag = $('>.jScrollPaneTrack .jScrollPaneDrag', $container);


        var currentArrowDirection;
        var currentArrowTimerArr = []; // Array is used to store timers since they can stack up when dealing with keyboard events. This ensures all timers are cleaned up in the end, preventing an acceleration bug.
        var currentArrowInc;
        var whileArrowButtonDown = function() {
          if (currentArrowInc > 4 || currentArrowInc % 4 == 0) {
            positionDrag(dragPosition + currentArrowDirection * mouseWheelMultiplier);
          }
          currentArrowInc++;
        };

        if (settings.enableKeyboardNavigation) {
          $container.bind(
            'keydown.jscrollpane',
            function(e) {
              switch (e.keyCode) {
                case 38: //up
                  currentArrowDirection = -1;
                  currentArrowInc = 0;
                  whileArrowButtonDown();
                  currentArrowTimerArr[currentArrowTimerArr.length] = setInterval(whileArrowButtonDown, 100);
                  return false;
                case 40: //down
                  currentArrowDirection = 1;
                  currentArrowInc = 0;
                  whileArrowButtonDown();
                  currentArrowTimerArr[currentArrowTimerArr.length] = setInterval(whileArrowButtonDown, 100);
                  return false;
                case 33: // page up
                case 34: // page down
                  // TODO
                  return false;
                default:
              }
            }
          ).bind(
            'keyup.jscrollpane',
            function(e) {
              if (e.keyCode == 38 || e.keyCode == 40) {
                for (var i = 0; i < currentArrowTimerArr.length; i++) {
                  clearInterval(currentArrowTimerArr[i]);
                }
                return false;
              }
            }
          );
        }

        if (settings.showArrows) {

          var currentArrowButton;
          var currentArrowInterval;

          var onArrowMouseUp = function(event) {
            $('html').unbind('mouseup', onArrowMouseUp);
            currentArrowButton.removeClass('jScrollActiveArrowButton');
            clearInterval(currentArrowInterval);
          };
          var onArrowMouseDown = function() {
            $('html').bind('mouseup', onArrowMouseUp);
            currentArrowButton.addClass('jScrollActiveArrowButton');
            currentArrowInc = 0;
            whileArrowButtonDown();
            currentArrowInterval = setInterval(whileArrowButtonDown, 100);
          };
          $container
            .append(
              $('<a></a>')
              .attr({
                'href': 'javascript:;',
                'class': 'jScrollArrowUp',
                'tabindex': -1
              })
              .css({
                'width': settings.scrollbarWidth + 'px',
                'top': settings.topCapHeight + 'px'
              })
              .html('Scroll up')
              .bind('mousedown', function() {
                currentArrowButton = $(this);
                currentArrowDirection = -1;
                onArrowMouseDown();
                this.blur();
                return false;
              })
              .bind('click', rf),
              $('<a></a>')
              .attr({
                'href': 'javascript:;',
                'class': 'jScrollArrowDown',
                'tabindex': -1
              })
              .css({
                'width': settings.scrollbarWidth + 'px',
                'bottom': settings.bottomCapHeight + 'px'
              })
              .html('Scroll down')
              .bind('mousedown', function() {
                currentArrowButton = $(this);
                currentArrowDirection = 1;
                onArrowMouseDown();
                this.blur();
                return false;
              })
              .bind('click', rf)
            );
          var $upArrow = $('>.jScrollArrowUp', $container);
          var $downArrow = $('>.jScrollArrowDown', $container);
        }

        if (settings.arrowSize) {
          trackHeight = paneHeight - settings.arrowSize - settings.arrowSize;
          trackOffset += settings.arrowSize;
        } else if ($upArrow) {
          var topArrowHeight = $upArrow.height();
          settings.arrowSize = topArrowHeight;
          trackHeight = paneHeight - topArrowHeight - $downArrow.height();
          trackOffset += topArrowHeight;
        }
        trackHeight -= settings.topCapHeight + settings.bottomCapHeight;
        $track.css({
          'height': trackHeight + 'px',
          top: trackOffset + 'px'
        })

        var $pane = $(this).css({
          'position': 'absolute',
          'overflow': 'visible'
        });

        var currentOffset;
        var maxY;
        var mouseWheelMultiplier;
        // store this in a seperate variable so we can keep track more accurately than just updating the css property..
        var dragPosition = 0;
        var dragMiddle = percentInView * paneHeight / 2;

        // pos function borrowed from tooltip plugin and adapted...
        var getPos = function(event, c) {
          var p = c == 'X' ? 'Left' : 'Top';
          return event['page' + c] || (event['client' + c] + (document.documentElement['scroll' + p] || document.body['scroll' + p])) || 0;
        };

        var ignoreNativeDrag = function() {
          return false;
        };

        var initDrag = function() {
          ceaseAnimation();
          currentOffset = $drag.offset(false);
          currentOffset.top -= dragPosition;
          maxY = trackHeight - $drag[0].offsetHeight;
          mouseWheelMultiplier = 2 * settings.wheelSpeed * maxY / contentHeight;
        };

        var onStartDrag = function(event) {
          initDrag();
          dragMiddle = getPos(event, 'Y') - dragPosition - currentOffset.top;
          $('html').bind('mouseup', onStopDrag).bind('mousemove', updateScroll);
          if ($.browser.msie) {
            $('html').bind('dragstart', ignoreNativeDrag).bind('selectstart', ignoreNativeDrag);
          }
          return false;
        };
        var onStopDrag = function() {
          $('html').unbind('mouseup', onStopDrag).unbind('mousemove', updateScroll);
          dragMiddle = percentInView * paneHeight / 2;
          if ($.browser.msie) {
            $('html').unbind('dragstart', ignoreNativeDrag).unbind('selectstart', ignoreNativeDrag);
          }
        };
        var positionDrag = function(destY) {
          $container.scrollTop(0);
          destY = destY < 0 ? 0 : (destY > maxY ? maxY : destY);
          dragPosition = destY;
          $drag.css({
            'top': destY + 'px'
          });
          var p = destY / maxY;
          $this.data('jScrollPanePosition', (paneHeight - contentHeight) * -p);
          $pane.css({
            'top': ((paneHeight - contentHeight) * p) + 'px'
          });
          $this.trigger('scroll');
          if (settings.showArrows) {
            $upArrow[destY == 0 ? 'addClass' : 'removeClass']('disabled');
            $downArrow[destY == maxY ? 'addClass' : 'removeClass']('disabled');
          }
        };
        var updateScroll = function(e) {
          positionDrag(getPos(e, 'Y') - currentOffset.top - dragMiddle);
        };

        var dragH = Math.max(Math.min(percentInView * (paneHeight - settings.arrowSize * 2), settings.dragMaxHeight), settings.dragMinHeight);

        $drag.css({
          'height': dragH + 'px'
        }).bind('mousedown', onStartDrag);

        var trackScrollInterval;
        var trackScrollInc;
        var trackScrollMousePos;
        var doTrackScroll = function() {
          if (trackScrollInc > 8 || trackScrollInc % 4 == 0) {
            positionDrag((dragPosition - ((dragPosition - trackScrollMousePos) / 2)));
          }
          trackScrollInc++;
        };
        var onStopTrackClick = function() {
          clearInterval(trackScrollInterval);
          $('html').unbind('mouseup', onStopTrackClick).unbind('mousemove', onTrackMouseMove);
        };
        var onTrackMouseMove = function(event) {
          trackScrollMousePos = getPos(event, 'Y') - currentOffset.top - dragMiddle;
        };
        var onTrackClick = function(event) {
          initDrag();
          onTrackMouseMove(event);
          trackScrollInc = 0;
          $('html').bind('mouseup', onStopTrackClick).bind('mousemove', onTrackMouseMove);
          trackScrollInterval = setInterval(doTrackScroll, 100);
          doTrackScroll();
          return false;
        };

        $track.bind('mousedown', onTrackClick);

        $container.bind('mousewheel', function(event, delta) {
          delta = delta || (event.wheelDelta ? event.wheelDelta / 120 : (event.detail) ? -event.detail / 3 : 0);
          initDrag();
          ceaseAnimation();
          var d = dragPosition;
          positionDrag(dragPosition - delta * mouseWheelMultiplier);
          var dragOccured = d != dragPosition;
          return !dragOccured;
        });

        var _animateToPosition;
        var _animateToInterval;

        function animateToPosition() {
          var diff = (_animateToPosition - dragPosition) / settings.animateStep;
          if (diff > 1 || diff < -1) {
            positionDrag(dragPosition + diff);
          } else {
            positionDrag(_animateToPosition);
            ceaseAnimation();
          }
        }

        var ceaseAnimation = function() {
          if (_animateToInterval) {
            clearInterval(_animateToInterval);
            delete _animateToPosition;
          }
        };

        var scrollTo = function(pos, preventAni) {
          if (typeof pos == "string") {
            $e = $(pos, $this);
            if (!$e.length) return;
            pos = $e.offset().top - $this.offset().top;
          }
          ceaseAnimation();
          var maxScroll = contentHeight - paneHeight;
          pos = pos > maxScroll ? maxScroll : pos;
          $this.data('jScrollPaneMaxScroll', maxScroll);
          var destDragPosition = pos / maxScroll * maxY;
          if (preventAni || !settings.animateTo) {
            positionDrag(destDragPosition);
          } else {
            $container.scrollTop(0);
            _animateToPosition = destDragPosition;
            _animateToInterval = setInterval(animateToPosition, settings.animateInterval);
          }
        };

        $this[0].scrollTo = scrollTo;

        $this[0].scrollBy = function(delta) {
          var currentPos = -parseInt($pane.css('top')) || 0;
          scrollTo(currentPos + delta);
        };

        initDrag();

        scrollTo(-currentScrollPosition, true);

        // Deal with it when the user tabs to a link or form element within this scrollpane
        $('*', this).bind('focus', function(event) {
          var $e = $(this);

          // loop through parents adding the offset top of any elements that are relatively positioned between
          // the focused element and the jScrollPaneContainer so we can get the true distance from the top
          // of the focused element to the top of the scrollpane...
          var eleTop = 0;

          while ($e[0] != $this[0]) {
            eleTop += $e.position().top;
            $e = $e.offsetParent();
          }

          var viewportTop = -parseInt($pane.css('top')) || 0;
          var maxVisibleEleTop = viewportTop + paneHeight;
          var eleInView = eleTop > viewportTop && eleTop < maxVisibleEleTop;
          if (!eleInView) {
            var destPos = eleTop - settings.scrollbarMargin;
            if (eleTop > viewportTop) { // element is below viewport - scroll so it is at bottom.
              destPos += $(this).height() + 15 + settings.scrollbarMargin - paneHeight;
            }
            scrollTo(destPos);
          }
        });

        if (location.hash && location.hash.length > 1) {
          setTimeout(function() {
            scrollTo(location.hash);
          }, $.browser.safari ? 100 : 0);
        }

        // use event delegation to listen for all clicks on links and hijack them if they are links to
        // anchors within our content...
        $(document).bind('click', function(e) {
          $target = $(e.target);
          if ($target.is('a')) {
            var h = $target.attr('href');
            if (h && h.substr(0, 1) == '#' && h.length > 1) {
              setTimeout(function() {
                scrollTo(h, !settings.animateToInternalLinks);
              }, $.browser.safari ? 100 : 0);
            }
          }
        });

        // Deal with dragging and selecting text to make the scrollpane scroll...
        function onSelectScrollMouseDown(e) {
          $(document).bind('mousemove.jScrollPaneDragging', onTextSelectionScrollMouseMove);
          $(document).bind('mouseup.jScrollPaneDragging', onSelectScrollMouseUp);
        };

        var textDragDistanceAway;
        var textSelectionInterval;

        function onTextSelectionInterval() {
          direction = textDragDistanceAway < 0 ? -1 : 1;
          $this[0].scrollBy(textDragDistanceAway / 2);
        };

        function clearTextSelectionInterval() {
          if (textSelectionInterval) {
            clearInterval(textSelectionInterval);
            textSelectionInterval = undefined;
          }
        };

        function onTextSelectionScrollMouseMove(e) {
          var offset = $this.parent().offset().top;
          var maxOffset = offset + paneHeight;
          var mouseOffset = getPos(e, 'Y');
          textDragDistanceAway = mouseOffset < offset ? mouseOffset - offset : (mouseOffset > maxOffset ? mouseOffset - maxOffset : 0);
          if (textDragDistanceAway == 0) {
            clearTextSelectionInterval();
          } else {
            if (!textSelectionInterval) {
              textSelectionInterval = setInterval(onTextSelectionInterval, 100);
            }
          }
        };

        function onSelectScrollMouseUp(e) {
          $(document)
            .unbind('mousemove.jScrollPaneDragging')
            .unbind('mouseup.jScrollPaneDragging');
          clearTextSelectionInterval();
        };

        $container.bind('mousedown.jScrollPane', onSelectScrollMouseDown);
        $.jScrollPane.active.push($this[0]);
      } else {
        $this.css({
          'height': paneHeight + 'px',
          'width': paneWidth - this.originalSidePaddingTotal + 'px',
          'padding': this.originalPadding
        });
        $this[0].scrollTo = $this[0].scrollBy = function() {};
        /* clean up listeners */
        $this.parent().unbind('mousewheel').unbind('mousedown.jScrollPane').unbind('keydown.jscrollpane').unbind('keyup.jscrollpane');
      }
    });
  };

  $.fn.jScrollPaneRemove = function() {
    $(this).each(function() {
      $this = $(this);
      var $c = $this.parent();
      if ($c.is('.jScrollPaneContainer')) {
        $this.css({
          'top': '',
          'height': '',
          'width': '',
          'padding': '',
          'overflow': '',
          'position': ''
        });
        $this.attr('style', $this.data('originalStyleTag'));
        $c.after($this).remove();
      }
    });
  };

  $.fn.jScrollPane.defaults = {
    scrollbarWidth: 10,
    scrollbarMargin: 5,
    wheelSpeed: 18,
    showArrows: false,
    arrowSize: 0,
    animateTo: false,
    dragMinHeight: 1,
    dragMaxHeight: 99999,
    animateInterval: 100,
    animateStep: 3,
    maintainPosition: true,
    scrollbarOnLeft: false,
    reinitialiseOnImageLoad: false,
    tabIndex: 0,
    enableKeyboardNavigation: true,
    animateToInternalLinks: false,
    topCapHeight: 0,
    bottomCapHeight: 0
  };

  /* clean up the scrollTo expandos */
  $(window)
    .bind('unload', function() {
      var els = $.jScrollPane.active;
      for (var i = 0; i < els.length; i++) {
        els[i].scrollTo = els[i].scrollBy = null;
      }
    });
})(jQuery);

/* ============================================================================
|                                                                             |
|  popup.js                                                                   |
|                                                                             |
============================================================================ */

$(function() {
  $('.zakaz a').click(function() {
    var pageUrl = $(this).attr('href');
    $('body > div.bg').append('<div style="display: none;" class="for_vs" id="cl_overlay"></div>');
    $('body, html').animate({
      scrollTop: 0
    }, 2000);
    $('#cl_overlay').fadeIn('fast', function() {
      $.ajax({
        type: 'POST',
        url: pageUrl,
        data: {
          dynamic: 1
        },
        success: function(data) {
          $('body > div.bg').append(data);
          $('#cl_form').animate({
            top: '40px'
          }, 500);
        },
        error: function(xhr, status, thrown) {
          alert('Ошибка ajax-связи с сайтом!\n\nОписание: ' + thrown + '\n\nТип ошибки: ' + status);
        }
      });
    });
    return false;
  });

  $('#cl_overlay, #cl_form_close').live('click', function() {
    $('#cl_form').animate({
      top: '-1000px'
    }, 500, function() {
      $('#cl_overlay').fadeOut('fast').remove();
    }).remove();
  });

  $('select[name="variant_id"]').live('change', function() {
    var price = +$('select[name="variant_id"] option:selected').data('price');
    var stock = +$('#cl_form select[name="variant_id"] option:selected').data('stock');
    $('#cl_form_price b').html(price);
    $('#cl_form select[name="amount"] option').hide();
    $('#cl_form select[name="amount"] option:lt(' + stock + ')').show();
  });

  $('a[rel="add_to_cart"]').live('click', function() {
    var variant = +$('#cl_form select[name="variant_id"] option:selected').val();
    var amount = +$('#cl_form select[name="amount"] option:selected').val();
    $.ajax({
      url: 'cart/add/' + variant,
      type: 'POST',
      data: {
        amount: amount,
        ajax: 1
      },
      error: function(xhr, status, thrown) {
        alert('Ошибка ajax-связи с сайтом!\n\nОписание: ' + thrown + '\n\nТип ошибки: ' + status);
      },
      success: function(data) {
        $('#cart_informer').html(data);
        $('a[rel="add_to_cart"]').html($('a[rel="add_to_cart"]').data('result-text'));
      }
    });
    return false;
  });
});

/* ============================================================================
|                                                                             |
|  Запуск плагинов.                                                           |
|                                                                             |
============================================================================ */

$(document).ready(function() {
  $('.niceSelect').selectbox();
  $('.desc-info').jScrollPane({
    showArrows: false,
    scrollbarWidth: 12
  });
});

$(document).ready(function() {
  $('.cat-bl').hover(function() {
    $(this).find('.cat-desc-l').hide();
    $(this).find('.zakaz').show();
  }, function() {
    $(this).find('.cat-desc-l').show();
    $(this).find('.zakaz').hide();
  });
});

$(document).ready(function() {
  $('#i1').hover(function() {
    $('.i-win1').show();
  }, function() {
    $('.i-win1').hide();
  });
  $('#i2').hover(function() {
    $('.i-win2').show();
  }, function() {
    $('.i-win2').hide();
  });
  $('#i3').hover(function() {
    $('.i-win3').show();
  }, function() {
    $('.i-win3').hide();
  });
  $('#i4').hover(function() {
    $('.i-win4').show();
  }, function() {
    $('.i-win4').hide();
  });
});

/* ============================================================================
|                                                                             |
|  cloud-zoom.js                                                              |
|                                                                             |
============================================================================ */

//////////////////////////////////////////////////////////////////////////////////
// Cloud Zoom V1.0.2
// (c) 2010 by R Cecco. <http://www.professorcloud.com>
// MIT License
//
// Please retain this copyright header in all versions of the software
//////////////////////////////////////////////////////////////////////////////////
(function($) {
  $(document).ready(function() {
    $('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
  });

  function format(str) {
    for (var i = 1; i < arguments.length; i++) {
      str = str.replace('%' + (i - 1), arguments[i]);
    }
    return str;
  };

  function CloudZoom(jWin, opts) {
    var sImg = $('img', jWin);
    var img1;
    var img2;
    var zoomDiv = null;
    var $mouseTrap = null;
    var lens = null;
    var $tint = null;
    var softFocus = null;
    var $ie6Fix = null;
    var zoomImage;
    var controlTimer = 0;
    var cw, ch;
    var destU = 0;
    var destV = 0;
    var currV = 0;
    var currU = 0;
    var filesLoaded = 0;
    var mx,
      my;
    var ctx = this,
      zw;
    // Display an image loading message. This message gets deleted when the images have loaded and the zoom init function is called.
    // We add a small delay before the message is displayed to avoid the message flicking on then off again virtually immediately if the
    // images load really fast, e.g. from the cache.
    //var   ctx = this;
    setTimeout(function() {
      //                         <img src="/images/loading.gif"/>
      if ($mouseTrap === null) {
        var w = jWin.width();
        jWin.parent().append(format('<div style="width:%0px;position:absolute;top:75%;left:%1px;text-align:center" class="cloud-zoom-loading" >Загружается фото...</div>', w / 3, (w / 2) - (w / 6))).find(':last').css('opacity', 0.5);
      }
    }, 200);


    var ie6FixRemove = function() {

      if ($ie6Fix !== null) {
        $ie6Fix.remove();
        $ie6Fix = null;
      }
    };

    // Removes cursor, tint layer, blur layer etc.
    this.removeBits = function() {
      //$mouseTrap.unbind();
      if (lens) {
        lens.remove();
        lens = null;
      }
      if ($tint) {
        $tint.remove();
        $tint = null;
      }
      if (softFocus) {
        softFocus.remove();
        softFocus = null;
      }
      ie6FixRemove();

      $('.cloud-zoom-loading', jWin.parent()).remove();
    };


    this.destroy = function() {
      jWin.data('zoom', null);

      if ($mouseTrap) {
        $mouseTrap.unbind();
        $mouseTrap.remove();
        $mouseTrap = null;
      }
      if (zoomDiv) {
        zoomDiv.remove();
        zoomDiv = null;
      }
      //ie6FixRemove();
      this.removeBits();
      // DON'T FORGET TO REMOVE JQUERY 'DATA' VALUES
    };


    // This is called when the zoom window has faded out so it can be removed.
    this.fadedOut = function() {

      if (zoomDiv) {
        zoomDiv.remove();
        zoomDiv = null;
      }
      this.removeBits();
      //ie6FixRemove();
    };

    this.controlLoop = function() {
      if (lens) {
        // размеры миниатюры
        var miniW = sImg.outerWidth();
        var miniH = sImg.outerHeight();

        // размеры большого изображения
        var largeW = zoomImage.width;
        var largeH = zoomImage.height;

        // вычисляем координату курсора над миниатюрой
        var cursorX = mx - sImg.offset().left;
        var cursorY = my - sImg.offset().top;

        // координата линзы в пределах миниатюры
        var lensX = parseInt(cursorX - cw / 2);
        if (lensX > (miniW - cw)) lensX = miniW - cw;
        if (lensX < 0) lensX = 0;
        var lensY = parseInt(cursorY - ch / 2);
        if (lensY > (miniH - ch)) lensY = miniH - ch;
        if (lensY < 0) lensY = 0;

        // двигаем туда линзу и ее фон обратно
        lens.css({
          left: lensX,
          top: lensY,
          'background-position': (-lensX) + 'px ' + (-lensY) + 'px'
        });

        // масштабные коэффициенты между миниатюрой и большим изображением
        var scaleW = largeW / miniW;
        var scaleH = largeH / miniH;

        // размеры видимой части зум-окна (при условии, что оно справа от миниатюры)
        var wrapper = $('.product-left-wrapper');
        var zoomW = wrapper.width() - miniW - opts.adjustX;
        var zoomH = wrapper.height() - opts.adjustY;
        if (zoomW > 700) zoomW = 700;
        if (zoomH > 700) zoomH = 700;

        // координата зум-окна в пределах большого изображения
        var zoomX = parseInt(cursorX * scaleW - zoomW / 2);
        if (zoomX > (largeW - zoomW)) zoomX = largeW - zoomW;
        if (zoomX < 0) zoomX = 0;
        var zoomY = parseInt(cursorY * scaleH - zoomH / 2);
        if (zoomY > (largeH - zoomH)) zoomY = largeH - zoomH;
        if (zoomY < 0) zoomY = 0;

        // двигаем фон зум-окна обратно
        zoomDiv.css('background-position', (-zoomX) + 'px ' + (-zoomY) + 'px');

        // $('.thumb-title').text( 'large = ' + largeW + '*' + largeH + ' | ' +
        //                         'mini = ' + miniW + '*' + miniH + ' | ' +
        //                         'scale_large_mini = ' + (parseInt(scaleW * 100000 + 1) / 100000) + '*' + (parseInt(scaleH * 100000 + 1) / 100000) + ' | ' +
        //                         'zoom = ' + zoomW + '*' + zoomH + ' | ' +
        //                         'lens = ' + cw + '*' + ch + ' | ' +
        //                         'coord = ' + lensX + '*' + lensY + ' | ' +
        //                         'cursor = ' + parseInt(cursorX) + '*' + cursorY );
      }
      controlTimer = setTimeout(function() {
        ctx.controlLoop();
      }, 30);
    };

    this.init2 = function(img, id) {

      filesLoaded++;
      //console.log(img.src + ' ' + id + ' ' + img.width);
      if (id === 1) {
        zoomImage = img;
      }
      //this.images[id] = img;
      if (filesLoaded === 2) {
        this.init();
      }
    };

    /* Init function start.  */
    this.init = function() {
      // Remove loading message (if present);
      $('.cloud-zoom-loading', jWin.parent()).remove();


      /* Add a box (mouseTrap) over the small image to trap mouse events.
              It has priority over zoom window to avoid issues with inner zoom.
              We need the dummy background image as IE does not trap mouse events on
              transparent parts of a div.
              */
      $mouseTrap = jWin.parent().append(format("<div class='mousetrap' style='background-image:url(\".\");z-index:999;position:absolute;width:%0px;height:%1px;left:%2px;top:%3px;\'></div>", sImg.outerWidth(), sImg.outerHeight(), 0, 0)).find(':last');

      //////////////////////////////////////////////////////////////////////
      /* Do as little as possible in mousemove event to prevent slowdown. */
      $mouseTrap.bind('mousemove', this, function(event) {
        // Just update the mouse position
        mx = event.pageX;
        my = event.pageY;
      });
      //////////////////////////////////////////////////////////////////////
      $mouseTrap.bind('mouseleave', this, function(event) {
        clearTimeout(controlTimer);
        //event.data.removeBits();
        if (lens) {
          lens.fadeOut(299);
        }
        if ($tint) {
          $tint.fadeOut(299);
        }
        if (softFocus) {
          softFocus.fadeOut(299);
        }
        zoomDiv.fadeOut(300, function() {
          ctx.fadedOut();
        });
        return false;
      });
      //////////////////////////////////////////////////////////////////////
      $mouseTrap.bind('mouseenter', this, function(event) {
        mx = event.pageX;
        my = event.pageY;
        zw = event.data;
        if (zoomDiv) {
          zoomDiv.stop(true, false);
          zoomDiv.remove();
        }

        var xPos = opts.adjustX,
          yPos = opts.adjustY;

        var siw = sImg.outerWidth();
        var sih = sImg.outerHeight();

        var w = opts.zoomWidth;
        var h = opts.zoomHeight;
        if (opts.zoomWidth == 'auto') {
          w = siw;
        }
        if (opts.zoomHeight == 'auto') {
          h = sih;
        }
        //$('#info').text( xPos + ' ' + yPos + ' ' + siw + ' ' + sih );
        var appendTo = jWin.parent(); // attach to the wrapper
        switch (opts.position) {
          case 'top':
            yPos -= h; // + opts.adjustY;
            break;
          case 'right':
            xPos += siw; // + opts.adjustX;
            break;
          case 'bottom':
            yPos += sih; // + opts.adjustY;
            break;
          case 'left':
            xPos -= w; // + opts.adjustX;
            break;
          case 'inside':
            w = siw;
            h = sih;
            break;
            // All other values, try and find an id in the dom to attach to.
          default:
            appendTo = $('#' + opts.position);
            // If dom element doesn't exit, just use 'right' position as default.
            if (!appendTo.length) {
              appendTo = jWin;
              xPos += siw; //+ opts.adjustX;
              yPos += sih; // + opts.adjustY;
            } else {
              w = appendTo.innerWidth();
              h = appendTo.innerHeight();
            }
        }

        zoomDiv = appendTo.append(format('<div id="cloud-zoom-big" class="cloud-zoom-big" style="display: none; position: absolute; left: %0px; top: %1px; width: %2px; height: %3px; background: url(\'%4\') 0 0 no-repeat; z-index: 99;"></div>', xPos, yPos, w * 7, h * 7, zoomImage.src)).find(':last');

        // Add the title from title tag.
        if (sImg.attr('title') && opts.showTitle) {
          zoomDiv.append(format('<div class="cloud-zoom-title">%0</div>', sImg.attr('title'))).find(':last').css('opacity', opts.titleOpacity);
        }

        // Fix ie6 select elements wrong z-index bug. Placing an iFrame over the select element solves the issue...
        if ($.browser.msie && $.browser.version < 7) {
          $ie6Fix = $('<iframe frameborder="0" src="#"></iframe>').css({
            position: "absolute",
            left: xPos,
            top: yPos,
            zIndex: 99,
            width: w,
            height: h
          }).insertBefore(zoomDiv);
        }

        zoomDiv.fadeIn(500);

        if (lens) {
          lens.remove();
          lens = null;
        } /* Work out size of cursor */
        cw = (sImg.outerWidth() / zoomImage.width) * zoomDiv.width();
        ch = (sImg.outerHeight() / zoomImage.height) * zoomDiv.height();
        cw = w;
        ch = h;

        // Attach mouse, initially invisible to prevent first frame glitch
        lens = jWin.append(format("<div class = 'cloud-zoom-lens' style='display:none;z-index:98;position:absolute;width:%0px;height:%1px;'></div>", cw, ch)).find(':last');

        $mouseTrap.css('cursor', lens.css('cursor'));

        var noTrans = false;

        // Init tint layer if needed. (Not relevant if using inside mode)
        if (opts.tint) {
          lens.css('background', 'url("' + sImg.attr('src') + '")');
          $tint = jWin.append(format('<div style="display:none;position:absolute; left:0px; top:0px; width:%0px; height:%1px; background-color:%2;" />', sImg.outerWidth(), sImg.outerHeight(), opts.tint)).find(':last');
          $tint.css('opacity', opts.tintOpacity);
          noTrans = true;
          $tint.fadeIn(500);

        }
        if (opts.softFocus) {
          lens.css('background', 'url("' + sImg.attr('src') + '")');
          softFocus = jWin.append(format('<div style="position:absolute;display:none;top:2px; left:2px; width:%0px; height:%1px;" />', sImg.outerWidth() - 2, sImg.outerHeight() - 2, opts.tint)).find(':last');
          softFocus.css('background', 'url("' + sImg.attr('src') + '")');
          softFocus.css('opacity', 0.5);
          noTrans = true;
          softFocus.fadeIn(500);
        }

        if (!noTrans) {
          lens.css('opacity', opts.lensOpacity);
        }
        if (opts.position !== 'inside') {
          lens.fadeIn(500);
        }

        // Start processing.
        zw.controlLoop();

        return; // Don't return false here otherwise opera will not detect change of the mouse pointer type.
      });
    };

    img1 = new Image();
    $(img1).load(function() {
      ctx.init2(this, 0);
    });
    img1.src = sImg.attr('src');

    img2 = new Image();
    $(img2).load(function() {
      ctx.init2(this, 1);
    });
    img2.src = jWin.attr('href');
  };

  $.fn.CloudZoom = function(options) {
    // IE6 background image flicker fix
    try {
      document.execCommand("BackgroundImageCache", false, true);
    } catch (e) {}
    this.each(function() {
      var relOpts, opts;
      // Hmm...eval...slap on wrist.
      eval('var a = {' + $(this).attr('rel') + '}');
      relOpts = a;
      if ($(this).is('.cloud-zoom')) {
        $(this).css({
          'position': 'relative',
          'display': 'block'
        });
        $('img', $(this)).css({
          'display': 'block'
        });
        // Wrap an outer div around the link so we can attach things without them becoming part of the link.
        // But not if wrap already exists.
        if ($(this).parent().attr('id') != 'wrap') {
          $(this).wrap('<div id="wrap" style="top:0px;z-index:9999;position:relative;"></div>');
        }
        opts = $.extend({}, $.fn.CloudZoom.defaults, options);
        opts = $.extend({}, opts, relOpts);
        $(this).data('zoom', new CloudZoom($(this), opts));

      } else if ($(this).is('.cloud-zoom-gallery')) {
        opts = $.extend({}, relOpts, options);
        $(this).data('relOpts', opts);
        $(this).bind('click', $(this), function(event) {
          var data = event.data.data('relOpts');
          // Destroy the previous zoom
          $('#' + data.useZoom).data('zoom').destroy();
          // Change the biglink to point to the new big image.
          $('#' + data.useZoom).attr('href', event.data.attr('href'));
          // Change the small image to point to the new small image.
          $('#' + data.useZoom + ' img').attr('src', event.data.data('relOpts').smallImage);
          // Init a new zoom with the new images.
          $('#' + event.data.data('relOpts').useZoom).CloudZoom();
          return false;
        });
        $(this).bind('mouseenter', $(this), function(event) {
          var data = event.data.data('relOpts');
          // Destroy the previous zoom
          $('#' + data.useZoom).data('zoom').destroy();
          // Change the biglink to point to the new big image.
          $('#' + data.useZoom).attr('href', event.data.attr('href'));
          // Change the small image to point to the new small image.
          $('#' + data.useZoom + ' img').attr('src', event.data.data('relOpts').smallImage);
          // Init a new zoom with the new images.
          $('#' + event.data.data('relOpts').useZoom).CloudZoom();
          return false;
        });
      }
    });
    return this;
  };

  $.fn.CloudZoom.defaults = {
    zoomWidth: 'auto',
    zoomHeight: 'auto',
    position: 'right',
    tint: false,
    tintOpacity: 0.5,
    lensOpacity: 0.5,
    softFocus: false,
    smoothMove: 3,
    showTitle: true,
    titleOpacity: 0.5,
    adjustX: 0,
    adjustY: 0
  };
})(jQuery);

/* ============================================================================
|                                                                             |
|  skdslider.js                                                               |
|                                                                             |
============================================================================ */

/* =========================================================
// SKD Slider
// Update Date: 2013-12-24
// Author: Samir Kumar Das
// Mail: cse.samir@gmail.com
// Web: http://dandywebsolution.com/skdslider
// Version: 1.2
 *  $('#demo').skdslider({'delay':5000, 'animationSpeed': 2000});
 *
// ========================================================= */
(function($) {
  $.skdslider = function(container, options) {
    // settings
    var config = {
      'delay': 5000,
      'animationSpeed': 2000,
      'showNav': true,
      'autoSlide': true,
      'showNextPrev': false,
      'pauseOnHover': false,
      'numericNav': false,
      'stopSlidingAfter': false,
      'showPlayButton': false,
      'animationType': 'fading',
      /* fading/sliding */
    };

    if (options) {
      $.extend(config, options);
    }
    // variables

    var touch = (("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch);


    if ($(container).closest('div.skdslider').length == 0) $(container).wrap('<div class="skdslider"></div>');
    var element = $(container).closest('div.skdslider');
    element.find('ul').addClass('slides');
    var slides = element.find('ul.slides li');
    var targetSlide = 0;
    config.currentSlide = 0;
    config.currentState = 'pause';
    config.running = false;

    if (config.stopSlidingAfter) {
      if (config.stopSlidingAfter == 'all') {
        config.stopSlidingAfter = slides.length;
      }
      config.stopSlidingAfter -= 1;
    }

    if (config.animationType == 'fading') {
      slides.each(function() {
        $(this).css({
          'position': 'absolute',
          'left': '0',
          'top': '0',
          'bottom': '0',
          'right': '0'
        });
      });
    }

    if (config.animationType == 'sliding') {
      slides.each(function() {
        $(this).css({
          'float': 'left',
          'display': 'block',
          'position': 'relative'
        });
      });

      var totalWidth = element.outerWidth() * slides.size();
      element.find('ul.slides').css({
        'position': 'absolute',
        'left': '0',
        'width': totalWidth
      });
      slides.css({
        'width': element.outerWidth(),
        'height': element.outerHeight()
      });

      $(window).resize(function() {
        var totalWidth = element.outerWidth() * slides.size();
        element.find('ul.slides').css({
          'position': 'absolute',
          'left': '0',
          'width': totalWidth
        });
        slides.css({
          'width': element.outerWidth(),
          'height': element.outerHeight()
        });
      });
    }

    //if (touch)
    $.skdslider.enableTouch(element, slides, config);

    $.skdslider.createNav(element, slides, config);
    slides.eq(targetSlide).show();
    if (config.autoSlide == true) {
      config.currentState = 'play';
      config.interval = setTimeout(function() {
        $.skdslider.playSlide(element, slides, config);
      }, config.delay);
    }

    if (config.pauseOnHover == true) {
      slides.hover(function() {
        if (config.autoSlide == true) {
          config.currentState = 'pause';
          clearTimeout(config.interval);
        }
      }, function() {
        if (config.autoSlide == true) {
          config.currentState = 'play';
          if (config.autoSlide == true) $.skdslider.playSlide(element, slides, config);
        }
      });
    }
  };

  $.skdslider.createNav = function(element, slides, config) {
    var slideSet = '<ul class="slide-navs">';
    for (i = 0; i < slides.length; i++) {
      var slideContent = '';
      if (config.numericNav == true) slideContent = (i + 1);
      if (i == 0)
        slideSet += '<li class="current-slide slide-nav-' + i + '"><a>' + slideContent + '</a></li>';
      else
        slideSet += '<li class="slide-nav-' + i + '"><a>' + slideContent + '</a></li>';
    }
    slideSet += '</ul>';

    if (config.showNav == true) {
      element.append(slideSet);
      var nav_width = element.find('.slide-navs')[0].offsetWidth;
      nav_width = parseInt((nav_width / 2));
      nav_width = (-1) * nav_width;
      element.find('.slide-navs').css('margin-left', nav_width);
      // Slide marker clicked
      element.find('.slide-navs li').click(function() {
        index = element.find('.slide-navs li').index(this);
        targetSlide = index;
        clearTimeout(config.interval);
        config.currentState = 'play';
        config.running = false;
        $.skdslider.playSlide(element, slides, config, targetSlide);
        return false;
      });
    }

    if (config.showNextPrev == true) {
      var nextPrevButton = '<a class="prev"></a>';
      nextPrevButton += '<a class="next"></a>';

      element.append(nextPrevButton);

      element.find('a.prev').click(function() {
        $.skdslider.prev(element, slides, config);
      });

      element.find('a.next').click(function() {
        $.skdslider.next(element, slides, config);
      });
    }

    if (config.showPlayButton == true) {
      var playPause = (config.currentState == 'play' || config.autoSlide == true) ? '<a class="play-control pause"></a>' : '<a class="play-control play"></a>';
      element.append(playPause);
      element.hover(function() {
        element.find('a.play-control').css('display', 'block');
      }, function() {
        element.find('a.play-control').css('display', 'none');
      });

      element.find('a.play-control').click(function() {
        if (config.autoSlide == true) {
          clearTimeout(config.interval);
          config.autoSlide = false;
          config.currentState = 'pause';
          $(this).addClass('play');
          $(this).removeClass('pause');
        } else {
          config.currentState = 'play';
          config.autoSlide = true;
          $(this).addClass('pause');
          $(this).removeClass('play');

          if ((config.currentSlide + 1) == slides.length) targetSlide = 0;
          else targetSlide = (config.currentSlide + 1);

          clearTimeout(config.interval);
          $.skdslider.playSlide(element, slides, config, targetSlide);
        }
        return false;
      });
    }

  };

  $.skdslider.next = function(element, slides, config) {
    if ((config.currentSlide + 1) == slides.length) targetSlide = 0;
    else targetSlide = (config.currentSlide + 1);

    clearTimeout(config.interval);
    config.currentState = 'play';
    $.skdslider.playSlide(element, slides, config, targetSlide);
    return false;
  };

  $.skdslider.prev = function(element, slides, config) {
    if (config.currentSlide == 0) targetSlide = (slides.length - 1);
    else targetSlide = (config.currentSlide - 1);

    clearTimeout(config.interval);
    config.currentState = 'play';
    config.running = false;
    $.skdslider.playSlide(element, slides, config, targetSlide);
    return true;
  };

  $.skdslider.prev = function(element, slides, config) {
    if (config.currentSlide == 0) targetSlide = (slides.length - 1);
    else targetSlide = (config.currentSlide - 1);

    clearTimeout(config.interval);
    config.currentState = 'play';
    config.running = false;
    $.skdslider.playSlide(element, slides, config, targetSlide);
    return true;
  };

  $.skdslider.playSlide = function(element, slides, config, targetSlide) {
    if (config.currentState == 'play' && config.running == false) {
      element.find('.slide-navs li').removeClass('current-slide');
      if (typeof(targetSlide) == 'undefined') {
        targetSlide = (config.currentSlide + 1 == slides.length) ? 0 : config.currentSlide + 1;
      }
      if (config.animationType == 'fading') {
        config.running = true;
        slides.eq(config.currentSlide).fadeOut(config.animationSpeed);
        slides.eq(targetSlide).fadeIn(config.animationSpeed, function() {
          $.skdslider.removeIEFilter($(this)[0]);
          config.running = false;
        });
      }
      if (config.animationType == 'sliding') {
        var left = (targetSlide * element.outerWidth()) * (-1);
        config.running = true;
        element.find('ul.slides').animate({
          left: left
        }, config.animationSpeed, function() {
          config.running = false;
        });
      }
      element.find('.slide-navs li').eq(targetSlide).addClass('current-slide');
      config.currentSlide = targetSlide;
    }

    if (config.stopSlidingAfter && config.stopSlidingAfter == config.currentSlide) {

      clearTimeout(config.interval);
      config.autoSlide = false;
      config.currentState = 'pause';
      element.find('a.play-control').addClass('play');
      element.find('a.play-control').removeClass('pause');
    }

    if (config.autoSlide == true && config.currentState == 'play') {
      config.interval = setTimeout((function() {
        $.skdslider.playSlide(element, slides, config);
      }), config.delay);
    }
  };

  $.skdslider.enableTouch = function(element, slides, config) {
    element[0].addEventListener('touchstart', onTouchStart, false);
    var startX;
    var startY;
    var dx;
    var dy;

    function onTouchStart(e) {
      startX = e.touches[0].pageX;
      startY = e.touches[0].pageY;
      element[0].addEventListener('touchmove', onTouchMove, false);
      element[0].addEventListener('touchend', onTouchEnd, false);
    };

    function onTouchMove(e) {
      e.preventDefault();
      var x = e.touches[0].pageX;
      var y = e.touches[0].pageY;
      dx = startX - x;
      dy = startY - y;
    };

    function onTouchEnd(e) {
      element[0].removeEventListener('touchmove', onTouchMove, false);
      if (dx > 0) {
        $.skdslider.next(element, slides, config);
      } else {
        $.skdslider.prev(element, slides, config);
      }
      element[0].removeEventListener('touchend', onTouchEnd, false);
    };
  };

  $.skdslider.removeIEFilter = function(elm) {
    if (elm.style.removeAttribute) {
      elm.style.removeAttribute('filter');
    }
  };

  $.fn.skdslider = function(options) {
    return this.each(function() {
      (new $.skdslider(this, options));
    });
  };
})(jQuery);

/* ============================================================================
|                                                                             |
|  Запуск плагинов.                                                           |
|                                                                             |
============================================================================ */

$(document).ready(function() {
  $('#slider').skdslider({
    delay: 4000,
    fadeSpeed: 5000,
    animationType: 'fading',
    showNav: false,
    showNextPrev: false,
    showPlayButton: false,
    autoStart: true
  });
});

/* ============================================================================
|                                                                             |
|  Скрипты формы Быстрый заказ.                                               |
|                                                                             |
============================================================================ */

function startQuickOrderScripts() {
  $(function() {
    $('div.options a').toggle(function(e) {
      var btn = $(this);
      var line = btn.closest('li');
      var amount = line.find('div.amount');
      btn.addClass('selected');
      amount.fadeIn();
      return false;
    }, function(e) {
      var btn = $(this);
      var line = btn.closest('li');
      var amount = line.find('div.amount');
      btn.removeClass('selected');
      amount.fadeOut();
    });

    $('div.spinner i').click(function() {
      var btn = $(this);
      var input = $(this).closest('div.amount').find('input[type="text"]');
      var max = input.data('max');
      var amount = +input.val();
      if ($(this).hasClass('spinner-up')) {
        amount = ++amount;
        if (amount > max) amount = --amount;
        input.val(amount);
      } else {
        amount = --amount;
        if (amount == 0) amount = 1;
        input.val(amount);
      }
    });

    $('.addtocard').click(function() {
      var button = $(this);
      var form = $('form[name="variants"]');
      var lines = form.find('li:not(.first)');
      if (form.find('a.selected').length) {
        lines.each(function() {
          var t = $(this),
            link = t.find('a'),
            variant = link.data('id'),
            amount = +t.find('input').val();
          if (link.hasClass('selected')) {
            $.ajax({
              url: 'cart/add/' + variant,
              type: 'POST',
              data: {
                amount: amount,
                ajax: 1
              },
              error: function(xhr, status, thrown) {
                alert('Ошибка ajax-связи с сайтом!\r\rОписание: ' + thrown + '\r\rТип ошибки: ' + status);
              },
              success: function(data) {
                $('#cart_informer').html(data);
                if (button.attr('data-result-text')) button.val(button.attr('data-result-text'));
                link.click();
              }
            });
          }
        });
      } else form.find('div.error').fadeIn();
      return false;
    });
  });

}
