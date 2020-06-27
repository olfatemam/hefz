/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */


function VerseRect(x, y, w, h, check_empty)
{
    this.x=x;
    this.y=y;
    this.w=w;
    this.h=h;
    this.check_empty = check_empty;
}

VerseRect.prototype.point_is_inside=function(x, y)
{
    if(this.x<=x && x< this.x+this.w && this.y<=y && y< this.y+this.h)return true;
    return false;
}

VerseRect.prototype.is_empty_rect=function(ctx, color=false)
{
  try{
    var is_empty=true;
    var canvas = document.getElementById('pages_canvas');

    if(canvas.width<=10 || canvas.height<=10 )return true;    

    var org_width=this.w;
    var org_height=this.h;

    if(this.w-10 <=0|| this.h-10 <=0)return true;
    if(this.w-10 <=0)this.w=16;
    if(this.h-10 <=0)this.h=16;

    //var imgData=ctx.getImageData(this.x+2, this.y+2, this.w-4, this.h-4);
    var imgData=ctx.getImageData(this.x+5, this.y+5, this.w-10, this.h-10);

    for (var i=0;i<imgData.data.length;i+=4)
    {
        if(imgData.data[i]!=0 || imgData.data[i+1]!=0 || imgData.data[i+2]!=0 || imgData.data[i+3]!=0 )
        {
            //console.log('not empty');
            is_empty=false;
            break;
        }
    }
    this.w=org_width;
    this.h=org_height;
    return is_empty;
  }
  catch(err)
  {
  }
  return true;
}

VerseRect.prototype.draw=function(ctx, highlight_color)
{

    if(this.check_empty == true && this.is_empty_rect(ctx)==true)// this.x+5, this.y + 5, this.w-10, this.w-10)==true)
        return;


    if(this.w < 15 && this.is_empty_rect(ctx) == true )
    {
        return;
    }
    ctx.globalAlpha = 0.2;
    var oldfs = ctx.fillStyle;
    ctx.fillStyle = highlight_color;
    ctx.rect(this.x, this.y, this.w, this.h);
    ctx.fillRect(this.x, this.y, this.w, this.h);
    ctx.globalAlpha = 1.0;
    ctx.fillStyle = oldfs;
};
