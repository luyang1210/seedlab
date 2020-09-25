from .Layer import Layer
from seedsim.core import Registry, ScopedRegistry, Node, Interface, Network
from typing import List
from functools import partial

def addProtocol(node: Node, protocol: str, name: str, body: str):
    """!
    @brief Add a new protocol to BIRD on the given node.

    This method is to be injected in to router node class objects.

    @param node node to operator on.
    @param protocol protocol type. (e.g., bgp, ospf)
    @param name protocol name.
    @param body protocol body.
    """
    print("===== RoutingLayer: TODO: Handle API: do addProtocol {} {} on Node {}@as{}.".format(protocol, name, node.getName(), node.getAsn()))

class Routing(Layer):
    """!
    @brief The Routing layer.

    This layer provides routing support for routers and hosts. i.e., (1) install
    BIRD on router nodes and allow BGP/OSPF to work, (2) setup kernel and device
    protocols, and (3) setup defult routes for host nodes.
    """

    __reg: Registry = Registry()
    
    def getName(self) -> str:
        return "Routing"

    def getDependencies(self) -> List[str]:
        return ["Base"]

    def onRender(self):
        for ((scope, type, name), obj) in self.__reg.getAll().items():
            if type == 'rs':
                print("===== RoutingLayer: TODO: Bootstrap bird.conf for RS {}".format(name))
                obj.addProtocol = partial(addProtocol, obj) # "inject" the method
                
            if type == 'rnode':
                print("===== RoutingLayer: TODO: Bootstrap bird.conf for AS{} router {}".format(scope, name))
                obj.addProtocol = partial(addProtocol, obj) # "inject" the method

            if type == 'hnode':
                hifaces: List[Interface] = obj.getInterfaces()
                assert len(hifaces) == 1, 'Host {} in as{} has != 1 interfaces'.format(name, scope)
                hif = hifaces[0]
                hnet: Network = hif.getNet()
                rif: Interface = None

                cur_scope = ScopedRegistry(scope)
                for router in cur_scope.getByType('rnode'):
                    if rif != None: break
                    for riface in router.getInterfaces():
                        if riface.getNet() == hnet:
                            rif = riface
                            break
                
                assert rif != None, 'Host {} in as{} in network {}: no router'.format(name, scope, hnet.getName())
                print("===== RoutingLayer: TODO: Set default route for host {} ({}) to router {}".format(name, hif.getAddress(), rif.getAddress()))

    def print(self, indent: int) -> str:
        out = ' ' * indent
        out += 'RoutingLayer:\n'

        indent += 4
        out += ' ' * indent

        out += '<RoutingLayer does not have configurable options>\n'


        return out