{{ include(template_from_string(headerPHP)) }}
namespace {{ vendorName|pascal }}\{{ moduleName|pascal }}\Queue;

use Magento\Framework\MessageQueue\Publisher as FrameworkPublisher;
use {{ vendorName|pascal }}\{{ moduleName|pascal }}\Api\Data\{{ topic|pascal }}RequestInterface;

class {{ topic|pascal }}Publisher
{
    public const TOPIC = '{{ vendorName|snake }}.{{ moduleName|snake }}.{{ topic|snake }}';

    private FrameworkPublisher $frameworkPublisher;

    public function __construct(FrameworkPublisher $frameworkPublisher)
    {
        $this->frameworkPublisher = $frameworkPublisher;
    }

    public function publish({{ topic|pascal }}RequestInterface $request): void
    {
        $this->frameworkPublisher->publish(self::TOPIC, $request);
    }
}
