from seedsim.layers import Base
from seedsim.core import Registry

base = Base()

as150 = base.createAutonomousSystem(150)
as150_net0 = as150.createNetwork("net0")

as151 = base.createAutonomousSystem(151)
as151_net0 = as151.createNetwork("net0") 
as151_net1 = as151.createNetwork("net1")

print(base)
print(Registry())