<?php

namespace Github\Normalizer;

use Jane\JsonSchemaRuntime\Reference;
use Jane\JsonSchemaRuntime\Normalizer\CheckArray;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class OrgsOrgTeamsTeamSlugDiscussionsDiscussionNumberCommentsCommentNumberReactionsPostBodyNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === 'Github\\Model\\OrgsOrgTeamsTeamSlugDiscussionsDiscussionNumberCommentsCommentNumberReactionsPostBody';
    }
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && get_class($data) === 'Github\\Model\\OrgsOrgTeamsTeamSlugDiscussionsDiscussionNumberCommentsCommentNumberReactionsPostBody';
    }
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \Github\Model\OrgsOrgTeamsTeamSlugDiscussionsDiscussionNumberCommentsCommentNumberReactionsPostBody();
        if (\array_key_exists('content', $data)) {
            $object->setContent($data['content']);
        }
        return $object;
    }
    public function normalize($object, $format = null, array $context = array())
    {
        $data = array();
        if (null !== $object->getContent()) {
            $data['content'] = $object->getContent();
        }
        return $data;
    }
}