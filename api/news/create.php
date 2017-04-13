<div class="row margin-l-r-0 wrapper border-bottom white-bg page-heading">
    <h2>News</h2>
    <ol class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#news">News</a>
        </li>
        <li class="active">
            <span>New Article</span>
        </li>
    </ol>
</div>
<div class="row margin-l-r-0 m-20-15 wrapper-content  article" style="padding-left:0;padding-right:0;">
    <form id="articleForm">
        <div class="ibox">
            <div class="ibox-title">
                <div class="pull-left">
                    <h4>Create Article</h4>
                </div>
                <div class="pull-right">
                <input id="articleSubmit" type="submit" class="btn btn-success">
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="ibox-content">
                <h3><label>Title</label></h3>
                <div class="text-center">
                    <h1>
                        <input class="form-control" name="news_0_title">
                    </h1>
                </div>
                <h3>Content</h3>
                <textarea id="summernote" name="news_0_htmlcontent"></textarea>
                <hr>
                <div class="row margin-l-r-0">
                    <div class="col-md-12">
                        <h5>Tags:</h5>
                        <select multiple class="tags" data-role="tagsinput" name="news_0_tags"></select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="api/news/newsApi.js"></script>