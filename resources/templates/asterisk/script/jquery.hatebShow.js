/*
 * jQuery Hatena Bookmark Comments plugin 1.0
 *
 * http://yamashita.dyndns.org/
 *
 * Copyright (c) 2008 Hidetaka Yamashita
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
(function($) {
  $.fn.extend({
    hatebShow: function(commentOnly) {
      if (commentOnly == undefined) commentOnly = false;
      var div = this;

      function callback(data) {
        if (!data) return false;
        div.find("#hateb_count").text(data.count)
           .end()
           .append('<ul id="bookmarked_user"></ul>')
           .append('<div align="right">powered by <a href="http://yamashita.dyndns.org/blog/jquery-plugin-hatena-bookmark-comments/">hatebShow.js</a></div>');
        $.each(data.bookmarks, function(){
          var u = this.user;
          if (!commentOnly || this.comment != '')
              $('#bookmarked_user').append('<li><span class="hb_timestamp">' + this.timestamp.slice(0,10) + '</span> <img src="http://www.hatena.ne.jp/users/' + u.slice(0,2) + '/' + u + '/profile_s.gif" alt="' + u + '" title="' + u + '" /> <a href="http://b.hatena.ne.jp/' + u + '/">' + u + '</a> <span class="hb_tag">' + this.tags.join(', ') + '</span> <span class="hb_comment">' + this.comment + '</span></li>');
        });
      }

      // get JSON data with Hatena API
      $.getJSON("http://b.hatena.ne.jp/entry/json/?url=" + location.href + "&callback=?", callback);
      return this;
    }
  });
})(jQuery);