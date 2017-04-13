<div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading">
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
        <input class="form-control" name="news_0_id" value="<?php echo $article['_id']; ?>" style="display:none">
        <div class="ibox">
            <div class="ibox-title">
                <div class="pull-left">
                    <h4>Update Article</h4>
                </div>
                <div class="pull-right">
                    <input id="articleSubmit" type="submit" class="btn btn-success">
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="ibox-content">
                <div class="row margin-l-r-0">
                    <small class="pull-left">Created: <?php echo date('m/d/Y', strtotime($article['_timestampCreated'])); ?> by <strong><?php echo $createdBy; ?></strong></small>
                    <small class="pull-right">Last Updated: <?php echo date('m/d/Y', strtotime($article['_timestampModified'])); ?> by <strong><?php echo $modifiedBy; ?></strong></small><br>
                </div>
                <h3>Title</h3>
                <div class="text-center">
                    <h1>
                        <input class="form-control" name="news_0_title" value="<?php echo $article['title']; ?>">
                    </h1>
                </div>
                <h3>Content</h3>
                <textarea name="news_0_htmlcontent" id="summernote"><?php echo $article['htmlcontent']; ?></textarea>
                <hr>
                <div class="row margin-l-r-0">
                    <div class="col-md-12">
                        <h5>Tags:</h5>
                        <select name="news_0_tags" multiple class="tags" data-role="tagsinput">
                            <?php
                            foreach ($article['tags'] as $tag) {
                                ?>
                                <option value="<?php echo $tag['tagName']; ?>"><?php echo $tag['tagName']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="api/news/newsApi.js"></script>