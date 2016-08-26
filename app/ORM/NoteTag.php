<?php
/**
 * Real access class for table "note_tag"
 *
 * To extend the functionallity, edit here
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 *
 * 1.0.0
 * - Initial creation
 *
 * 1.1.0
 * - Add callbacks to run after insert, replace, update, delete and truncate
 *
 */
namespace ORM;

/**
 *
 */
class NoteTag extends NoteTagBase
{

    /**
     * Update hashtags for a given note
     */
    public static function updateHashTagsFromNote(Note $note) {

        $ORMNoteTag = new self;
        $ORMNoteTag->filterByNote($note->getId())->delete();
        $ORMNoteTag->reset()->setNote($note->getId());

        $ORMTag = new Tag;

        foreach ($note->getTags() as $tag) {
            $ORMTag->reset()->filterByTag($tag)->findOne();
            $ORMTag->getId() || $ORMTag->setTag($tag)->insert();
            $ORMNoteTag->setTag($ORMTag->getId())->insert();
        }

        // Remove orphan tags without notes
        Tag::removeOrphanTags();
    }

}
