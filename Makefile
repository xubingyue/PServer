SUBMODS = common centerp centerd smanagerd scened robotd

CLEANTARGET = clean
INSTALLTARGET = install
TAGSTARGET = tags
RELEASETARGET = release

SUBMODSCLEAN = $(patsubst %, %.$(CLEANTARGET), $(SUBMODS)) 
SUBMODSINSTALL = $(patsubst %, %.$(INSTALLTARGET), $(SUBMODS)) 
SUBMODSTAGS = $(patsubst %, %.$(TAGSTARGET), $(SUBMODS))
SUBMODSRELEASE = $(patsubst %, %.$(RELEASETARGET), $(SUBMODS))

.PHONY: all $(CLEANTARGET) $(INSTALLTARGET) $(SUBMODS) $(TAGSTARGET) $(RELEASETARGET)

all: $(SUBMODS)

$(CLEANTARGET): $(SUBMODSCLEAN)

$(INSTALLTARGET): $(SUBMODSINSTALL)

$(TAGSTARGET): $(SUBMODSTAGS)

$(RELEASETARGET): $(SUBMODSRELEASE)
	
$(SUBMODS):
	cd $@ && $(MAKE);

$(SUBMODSTAGS): 
	cd $(patsubst %.$(TAGSTARGET),%, $@)  && $(MAKE) $(TAGSTARGET);

$(SUBMODSCLEAN): 
	cd $(patsubst %.$(CLEANTARGET),%, $@)  && $(MAKE) $(CLEANTARGET);

$(SUBMODSINSTALL): 
	cd $(patsubst %.$(INSTALLTARGET),%, $@)  && $(MAKE) $(INSTALLTARGET);

$(SUBMODSRELEASE):
	cd $(patsubst %.$(RELEASETARGET),%, $@)  && $(MAKE) $(RELEASETARGET);

