<style>
    #screenFiller {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
<div>
    <object id="screenFiller" data="{{$file}}" type="application/pdf" width="100%" height="100%">
        <embed src="{{$file}}" type="application/pdf">
    </object>
</div>
