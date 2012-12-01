$(function(){
    $("#pic-list li").mtolay({dis:'.fave', cover:'.fave-cover', op:.85});
});

/*------------jquery plugin------------*/
(function($){
    $.fn.mtolay = function(opt){
        var o = $.extend({}, opt);
        return this.each(function(){
            var t = $(this), cd1 = 300, cd2 = 250;
            t.hover(
                function(){
                    var d = t.find(o.dis).stop(), c = t.find(o.cover).stop();
                    var h = parseInt(d.height()) + 12;
                    d.css({top:'-' + h + 'px'});
                    c.css({top:'-' + h + 'px'});
                    d.animate({top:0,opacity:1}, cd1).show();
                    c.animate({top:0,height:h + 'px',opacity:o.op}, cd2).show();
                },
                function (){
                    var d = t.find(o.dis).stop(), c = t.find(o.cover).stop();
                    var h = parseInt(d.height()) + 12;
                    d.animate({top:'-' + h + 'px',opacity:0}, cd2);
                    c.animate({top:'-' + h + 'px',opacity:0}, cd1);
                }
            );
        });
    };
})(jQuery);