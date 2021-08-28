<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BlogContentFixture extends Fixture
{

    /**
     * Const to store how many records should be created
     */
    CONST RECORDS_TO_CREATE = 5;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // create blogPosts objects and sets default data
        for ($i = 0; $i < self::RECORDS_TO_CREATE; $i++) {
            $blog = new Blog();
            $blog->setInsertDate(new DateTime());
            $blog->setTitle("Generic title " . $i);
            $blog->setText($this->getLoremIpsumText());
            $manager->persist($blog);
        }

        $manager->flush();
    }

    /**
     * Returns first paragraph of Lorem Ipsum
     *
     * @return string
     */
    private function getLoremIpsumText(): string
    {
        return "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sapien nisi, ultricies eu tellus ac, gravida commodo risus. Duis odio lectus, molestie eu venenatis in, rutrum non lectus. Etiam blandit imperdiet auctor. Proin consequat tortor non gravida porta. Fusce id ligula commodo, vehicula metus nec, ullamcorper lacus. Fusce sollicitudin dolor ut risus aliquet tempus. Sed cursus, magna eget efficitur ultricies, justo urna suscipit tellus, eget vestibulum metus nisl et lacus. Quisque consequat malesuada malesuada. Fusce sodales est ac tellus euismod commodo. Cras varius velit vel erat semper, eu aliquam nisi egestas. Nunc vitae velit lacinia, dapibus sem dapibus, lacinia massa. Nunc sed libero eget purus pharetra rutrum. Aenean id mollis metus, posuere lobortis tortor. Phasellus ut dolor eget tortor facilisis ullamcorper.";
    }
}