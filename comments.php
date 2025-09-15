<?php
/* session_start();
$_SESSION["pay"]="no"; */
/**
 * comments.php - Custom Tailwind styled comments template
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="mt-12">
    <?php if (have_comments()) : ?>
        <h3 class="text-xl font-semibold text-[#4a4a4a] mb-6">
            <?php
                $comments_number = get_comments_number();
                echo $comments_number === 1 ? "یک دیدگاه" : $comments_number . " دیدگاه";
            ?>
        </h3>

        <!-- لیست دیدگاه‌ها -->
        <ol class="space-y-6">
            <?php
                wp_list_comments([
                    'style'      => 'ol',
                    'avatar_size'=> 50,
                    'callback'   => function($comment, $args, $depth) {
                        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; ?>
                        
                        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class("bg-[#fafafa] p-5 rounded-xl shadow-md"); ?>>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <?php echo get_avatar($comment, 50, '', '', ['class' => 'rounded-full']); ?>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-[#4a4a4a]"><?php comment_author(); ?></p>
                                            <span class="text-xs text-gray-500"><?php comment_date('j F Y'); ?></span>
                                        </div>
                                        <?php edit_comment_link('ویرایش', '<span class="text-xs text-[#4a4a4a]">', '</span>'); ?>
                                    </div>
                                    <div class="prose prose-sm text-[#4a4a4a]">
                                        <?php if ($comment->comment_approved == '0') : ?>
                                            <em class="text-xs text-gray-400">دیدگاه شما در انتظار تأیید است.</em>
                                        <?php endif; ?>
                                        <?php comment_text(); ?>
                                    </div>
                                    <div class="mt-2">
                                        <?php comment_reply_link(array_merge($args, [
                                            'reply_text' => 'پاسخ',
                                            'depth'      => $depth,
                                            'max_depth'  => $args['max_depth'],
                                            'class'      => 'text-sm text-[#c9a6df] hover:underline'
                                        ])); ?>
                                    </div>
                                </div>
                            </div>
                        </<?php echo $tag; ?>>
                    <?php }
                ]);
            ?>
        </ol>

        <!-- ناوبری دیدگاه‌ها -->
        <div class="mt-6">
            <?php the_comments_navigation(); ?>
        </div>
    <?php endif; ?>

    <!-- فرم ارسال دیدگاه -->
    <div class="mt-10">
        <?php
            $fields = [
                'author' =>
                    '<div class="flex flex-col"><input id="author" name="author" type="text" placeholder="نام شما *" class="w-full rounded-lg border border-[#c0c0c0] p-3 focus:ring-2 focus:ring-[#c9a6df] focus:border-[#c9a6df]" required></div>',
                'email'  =>
                    '<div class="flex flex-col"><input id="email" name="email" type="email" placeholder="ایمیل شما *" class="w-full rounded-lg border border-[#c0c0c0] p-3 focus:ring-2 focus:ring-[#c9a6df] focus:border-[#c9a6df]" required></div>',
            ];

            comment_form([
                'title_reply'         => '<h3 class="text-xl font-semibold text-[#4a4a4a] mb-4">ارسال دیدگاه</h3>',
                'title_reply_before'  => '',
                'title_reply_after'   => '',
                'comment_notes_before'=> '',
                'comment_notes_after' => '',
                'class_form'          => 'space-y-4',
                'class_submit'        => 'bg-[#c9a6df] hover:bg-[#b18ccc] text-white font-medium px-5 py-2 rounded-lg transition',
                'label_submit'        => 'ارسال',
                'fields'              => $fields,
                'comment_field' =>
                    '<div class="flex flex-col"><textarea id="comment" name="comment" rows="5" placeholder="دیدگاه شما..." class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-[#c9a6df] focus:border-[#c9a6df]" required></textarea></div>',
                'logged_in_as' => '',
            ]);
        ?>
    </div>
</div>
